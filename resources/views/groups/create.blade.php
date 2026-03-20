@extends('layouts.app')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid rgba(124, 58, 237, 0.1);
    }

    .back-btn {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: linear-gradient(135deg, rgba(124,58,237,0.08), rgba(79,70,229,0.08));
        border: 2px solid rgba(124, 58, 237, 0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #7c3aed;
        text-decoration: none;
        transition: all 0.2s ease;
        flex-shrink: 0;
        font-size: 1.1rem;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, rgba(124,58,237,0.15), rgba(79,70,229,0.15));
        border-color: #7c3aed;
        transform: translateX(-2px);
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(90deg, #1e293b, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .form-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.7));
        border-radius: 20px;
        padding: 2.2rem;
        box-shadow: 0 12px 40px rgba(124,58,237,0.15), 0 4px 16px rgba(0,0,0,0.08), inset 0 1px 2px rgba(255,255,255,0.8);
        border: 1px solid rgba(124, 58, 237, 0.15);
        max-width: 580px;
        backdrop-filter: blur(10px);
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #7c3aed, #06b6d4, #4f46e5);
        border-radius: 20px 20px 0 0;
        background-size: 200% 100%;
        animation: gradientFlow 4s ease infinite;
    }

    @keyframes gradientFlow {
        0% { background-position: 0%; }
        50% { background-position: 100%; }
        100% { background-position: 0%; }
    }

    .form-card {
        position: relative;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 0.5rem;
        display: block;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }

    .form-control {
        border-radius: 12px;
        border: 2px solid rgba(124, 58, 237, 0.15);
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        color: #1e293b;
        width: 100%;
        font-family: 'Inter', sans-serif;
        background: rgba(255,255,255,0.7);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #7c3aed;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1), 0 4px 12px rgba(124, 58, 237, 0.15);
        outline: none;
    }

    .section-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 0.9rem;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }

    .member-check-item {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.7rem 0.95rem;
        border-radius: 12px;
        border: 2px solid rgba(124, 58, 237, 0.15);
        margin-bottom: 0.6rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background: rgba(255,255,255,0.5);
    }

    .member-check-item:hover {
        border-color: #7c3aed;
        background: rgba(124,58,237,0.05);
        transform: translateX(2px);
    }

    .member-check-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #7c3aed;
        cursor: pointer;
        border-radius: 4px;
    }

    .member-check-item span {
        font-size: 0.92rem;
        color: #1e293b;
        font-weight: 700;
    }

    .you-badge {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        border: 2px solid rgba(124, 58, 237, 0.3);
        background: linear-gradient(135deg, rgba(124,58,237,0.1), rgba(79,70,229,0.08));
        margin-bottom: 0.7rem;
        font-size: 0.95rem;
        font-weight: 700;
        color: #7c3aed;
    }

    .you-badge i {
        color: #a78bfa;
        font-size: 1.1rem;
    }

    .btn-submit {
        background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 50%, #0ea5e9 100%);
        background-size: 200% 200%;
        color: white;
        border: none;
        padding: 0.75rem 1.6rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s cubic-bezier(.4,0,.2,1);
        box-shadow: 0 8px 24px rgba(124,58,237,0.35), 0 4px 12px rgba(0,0,0,0.1);
        cursor: pointer;
        letter-spacing: 0.3px;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(124,58,237,0.45), 0 6px 16px rgba(0,0,0,0.15);
        background-position: 100% 50%;
    }

    .btn-submit:active {
        transform: translateY(-1px);
    }
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
            <div class="section-label">Friends</div>

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
            <p style="font-size:0.85rem;color:#94a3b8;margin:0;">You have no friends yet. Add friends from your <a href="{{ route('profile.edit') }}">profile</a> first.</p>
            @endif
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-people-fill"></i> Create Group
        </button>
    </form>
</div>

@endsection
