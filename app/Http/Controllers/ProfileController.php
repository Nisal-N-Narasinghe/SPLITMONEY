<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user()->load(['friends' => function ($query) {
            $query->orderBy('name');
        }]);

        $friendIds = $user->friends->pluck('id');
        $availableUsers = User::query()
            ->where('id', '!=', $user->id)
            ->where('is_admin', false)
            ->whereNotIn('id', $friendIds)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('profile.edit', [
            'user' => $user,
            'friends' => $user->friends,
            'availableUsers' => $availableUsers,
        ]);
    }

    public function addFriend(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'friend_ids' => ['required', 'array', 'min:1'],
            'friend_ids.*' => [
                'integer',
                Rule::exists('users', 'id')->where(function ($query) use ($user) {
                    return $query->where('is_admin', false)->where('id', '!=', $user->id);
                }),
            ],
        ]);

        $friendIds = collect($validated['friend_ids'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $existingIds = $user->friends()
            ->whereIn('friend_id', $friendIds)
            ->pluck('friend_id');

        $newFriendIds = $friendIds->diff($existingIds)->values();

        if ($newFriendIds->isEmpty()) {
            return back()->with('error', 'Selected users are already in your friends list.');
        }

        $user->friends()->attach($newFriendIds->all());

        $count = $newFriendIds->count();
        $message = $count === 1 ? '1 friend added successfully.' : $count . ' friends added successfully.';

        return back()->with('success', $message);
    }

    public function removeFriend(Request $request, User $friend)
    {
        $user = $request->user();

        if (! $user->friends()->where('friend_id', $friend->id)->exists()) {
            return back()->with('error', 'Friend not found in your list.');
        }

        $user->friends()->detach($friend->id);

        return back()->with('success', 'Friend removed from your list.');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile details updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('passwordUpdate', [
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Your current password is incorrect.',
            ], 'passwordUpdate')->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}
