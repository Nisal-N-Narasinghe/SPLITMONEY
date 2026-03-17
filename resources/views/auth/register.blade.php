<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — SplitMoney</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            box-shadow: 0 6px 20px rgba(14,165,233,0.35);
        }

        .brand-icon i { color: white; font-size: 1.5rem; }

        .brand-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            display: block;
        }

        .brand-sub {
            font-size: 0.85rem;
            color: #94a3b8;
        }

        .auth-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            border: 1px solid #f1f5f9;
        }

        .auth-card h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.3rem;
        }

        .auth-card p {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.83rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.4rem;
            display: block;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.9rem;
            padding: 0.6rem 0.85rem;
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

        .form-control.is-invalid { border-color: #f87171; }

        .invalid-feedback {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 0.3rem;
            display: block;
        }

        .btn-auth {
            width: 100%;
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: white;
            border: none;
            padding: 0.7rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            box-shadow: 0 3px 12px rgba(14,165,233,0.35);
            margin-top: 1.2rem;
        }

        .btn-auth:hover { opacity: 0.9; transform: translateY(-1px); }

        .auth-footer {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.85rem;
            color: #64748b;
        }

        .auth-footer a {
            color: #0ea5e9;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer a:hover { text-decoration: underline; }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .hint {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="brand">
        <div class="brand-icon"><i class="bi bi-cash-coin"></i></div>
        <span class="brand-name">SplitMoney</span>
        <span class="brand-sub">Split expenses with friends</span>
    </div>

    <div class="auth-card">
        <h2>Create an account</h2>
        <p>Join SplitMoney and start splitting expenses</p>

        @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
            <div><i class="bi bi-exclamation-circle-fill"></i> {{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Kasun Perera">
                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="you@example.com">
                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Min. 6 characters">
                <span class="hint">At least 6 characters</span>
                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="Repeat your password">
            </div>

            <button type="submit" class="btn-auth">
                <i class="bi bi-person-plus-fill"></i> Create Account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="/login">Sign in</a>
        </div>
    </div>
</div>
</body>
</html>
