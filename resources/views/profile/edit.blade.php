@extends('layouts.app')

@section('content')
<div class="page-header">
    <a href="/" class="back-btn"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h1 class="page-title mb-1">My Profile</h1>
        <p class="page-subtitle mb-0">Manage your account details and password.</p>
    </div>
</div>

<div class="profile-grid">
    <div class="profile-card">
        <h2 class="profile-card-title">Profile Details</h2>
        <p class="profile-card-subtitle">Update your display name and login email.</p>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-check2-circle"></i> Save Details
            </button>
        </form>
    </div>

    <div class="profile-card">
        <h2 class="profile-card-title">Reset Password</h2>
        <p class="profile-card-subtitle">Choose a new password to keep your account secure.</p>

        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <div class="password-input-wrap">
                    <input id="current_password" type="password" name="current_password" class="form-control password-toggle-input" required>
                    <button type="button" class="password-toggle-btn" data-toggle-password aria-label="Show password" aria-pressed="false">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('current_password', 'passwordUpdate')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <div class="password-input-wrap">
                    <input id="password" type="password" name="password" class="form-control password-toggle-input" required>
                    <button type="button" class="password-toggle-btn" data-toggle-password aria-label="Show password" aria-pressed="false">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password', 'passwordUpdate')
                    <div class="field-error">{{ $message }}</div>
                @enderror
                <div class="password-help mt-2">Use at least 8 characters.</div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <div class="password-input-wrap">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control password-toggle-input" required>
                    <button type="button" class="password-toggle-btn" data-toggle-password aria-label="Show password" aria-pressed="false">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-shield-lock"></i> Update Password
            </button>
        </form>
    </div>
</div>
<script>
document.querySelectorAll('[data-toggle-password]').forEach(function(button) {
    button.addEventListener('click', function() {
        const wrapper = button.closest('.password-input-wrap');
        const input = wrapper ? wrapper.querySelector('.password-toggle-input') : null;
        if (!input) {
            return;
        }

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        button.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
        button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        button.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });
});
</script>
@endsection
