@extends('layouts.app')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.8rem;
    }

    .back-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: white;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        flex-shrink: 0;
    }

    .back-btn:hover { background: #f1f5f9; color: #0f172a; }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        max-width: 560px;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.4rem;
        display: block;
    }

    .form-control {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        font-size: 0.9rem;
        padding: 0.55rem 0.85rem;
        color: #0f172a;
        width: 100%;
        font-family: 'Inter', sans-serif;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .form-control:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56,189,248,0.15);
        outline: none;
    }

    .section-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.75rem;
    }

    .member-check-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.6rem 0.8rem;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
    }

    .member-check-item:hover { border-color: #38bdf8; background: #f0f9ff; }

    .member-check-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #0ea5e9;
        cursor: pointer;
    }

    .member-check-item span {
        font-size: 0.9rem;
        color: #0f172a;
        font-weight: 500;
    }

    .you-badge {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.6rem 0.8rem;
        border-radius: 10px;
        border: 1.5px solid #bae6fd;
        background: #f0f9ff;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #0369a1;
    }

    .you-badge i { color: #0ea5e9; }

    .btn-submit {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: white;
        border: none;
        padding: 0.65rem 1.6rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: opacity 0.2s, transform 0.1s;
        box-shadow: 0 3px 10px rgba(14,165,233,0.35);
        cursor: pointer;
    }

    .btn-submit:hover { opacity: 0.9; transform: translateY(-1px); }
</style>

<div class="page-header">
    <a href="/" class="back-btn"><i class="bi bi-arrow-left"></i></a>
    <h1 class="page-title">Create Group</h1>
</div>

<div class="form-card">
    <form method="POST" action="/groups">
        @csrf

        <div class="mb-4">
            <label class="form-label">Group Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Trip to Bali" value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <div class="section-label">Members</div>

            <div class="you-badge">
                <i class="bi bi-person-fill"></i>
                {{ Auth::user()->name }} <span style="font-weight:400;color:#7dd3fc;">(you)</span>
            </div>

            @foreach($users as $user)
            <label class="member-check-item">
                <input type="checkbox" name="members[]" value="{{ $user->id }}"
                    {{ in_array($user->id, old('members', [])) ? 'checked' : '' }}>
                <span>{{ $user->name }}</span>
            </label>
            @endforeach

            @if($users->isEmpty())
            <p style="font-size:0.85rem;color:#94a3b8;margin:0;">No other users registered yet.</p>
            @endif
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-people-fill"></i> Create Group
        </button>
    </form>
</div>

@endsection
