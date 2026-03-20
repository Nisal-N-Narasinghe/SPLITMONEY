@extends('layouts.app')

@section('content')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.25rem;
    }

    .profile-card {
        position: relative;
        background: linear-gradient(160deg, rgba(255, 255, 255, 0.9), rgba(247, 249, 246, 0.9));
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        backdrop-filter: blur(10px);
        padding: 1.4rem;
    }

    .profile-card-title {
        font-family: 'Chakra Petch', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: #0f172a;
    }

    .profile-card-subtitle {
        margin-bottom: 1rem;
        color: #64748b;
        font-size: 0.88rem;
    }

    .form-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 0.45rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .form-control {
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.26);
        font-size: 0.92rem;
        padding: 0.65rem 0.85rem;
        color: #0f172a;
        background: #ffffff;
    }

    .form-control:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12), 0 8px 20px rgba(15, 23, 42, 0.08);
    }

    .password-input-wrap {
        position: relative;
    }

    .password-input-wrap .form-control {
        padding-right: 2.6rem;
    }

    .password-toggle-btn {
        position: absolute;
        right: 0.55rem;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: #64748b;
        width: 1.8rem;
        height: 1.8rem;
        border-radius: 0.45rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2;
    }

    .password-toggle-btn:hover {
        color: #0e7490;
        background: rgba(148, 163, 184, 0.14);
    }

    .field-error {
        margin-top: 0.3rem;
        font-size: 0.82rem;
        color: #b91c1c;
    }

    .btn-submit {
        background: linear-gradient(135deg, #0f766e, #0e7490 45%, #155e75);
        border: 1px solid rgba(14, 116, 144, 0.35);
        color: #f8fafc;
        border-radius: 12px;
        padding: 0.65rem 1.1rem;
        font-size: 0.9rem;
        font-weight: 700;
        font-family: 'Chakra Petch', sans-serif;
        letter-spacing: 0.02em;
    }

    .btn-submit:hover {
        filter: saturate(1.04);
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.14);
    }

    .password-help {
        font-size: 0.8rem;
        color: #64748b;
    }
</style>

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
