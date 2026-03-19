<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — SplitMoney</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background:
                radial-gradient(circle at 14% 18%, rgba(45, 212, 191, 0.2), transparent 36%),
                radial-gradient(circle at 86% 12%, rgba(34, 211, 238, 0.2), transparent 42%),
                radial-gradient(circle at 56% 82%, rgba(6, 182, 212, 0.14), transparent 45%),
                linear-gradient(145deg, #030712, #0f172a 48%, #082f49);
            color: #e2e8f0;
            overflow-x: hidden;
            position: relative;
        }

        .scene-grid {
            position: fixed;
            inset: 0;
            background-image: linear-gradient(rgba(125, 211, 252, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(34, 211, 238, 0.08) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(circle at center, black 34%, transparent 76%);
            pointer-events: none;
            opacity: 0.42;
        }

        .scene-orb {
            position: fixed;
            border-radius: 999px;
            filter: blur(7px);
            pointer-events: none;
        }

        .scene-orb-1 {
            width: 280px;
            height: 280px;
            left: -90px;
            top: 17%;
            background: radial-gradient(circle, rgba(45, 212, 191, 0.24), rgba(6, 182, 212, 0.03));
            animation: orbit-float 8.5s ease-in-out infinite;
        }

        .scene-orb-2 {
            width: 320px;
            height: 320px;
            right: -120px;
            bottom: 12%;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.26), rgba(14, 116, 144, 0.03));
            animation: orbit-float 10.5s ease-in-out infinite reverse;
        }

        @keyframes orbit-float {
            0%,
            100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .auth-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 2;
        }

        .brand {
            text-align: center;
            margin-bottom: 1.2rem;
        }

        .brand-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.33rem 0.7rem;
            border-radius: 999px;
            margin-bottom: 0.95rem;
            font-size: 0.68rem;
            letter-spacing: 0.11em;
            text-transform: uppercase;
            color: #a5f3fc;
            border: 1px solid rgba(103, 232, 249, 0.3);
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(8px);
        }

        .brand-chip i {
            color: #67e8f9;
        }

        .brand-icon {
            width: 62px;
            height: 62px;
            border-radius: 19px;
            background: linear-gradient(150deg, #22d3ee, #0284c7 56%, #14b8a6);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.7rem;
            box-shadow: 0 12px 34px rgba(6, 182, 212, 0.34), inset 0 1px 0 rgba(255, 255, 255, 0.32);
            position: relative;
            overflow: hidden;
        }

        .brand-icon::before {
            content: '';
            position: absolute;
            width: 27px;
            height: 27px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.94);
            left: 11px;
            top: 17px;
        }

        .brand-icon::after {
            content: '';
            position: absolute;
            width: 3px;
            height: 28px;
            right: 20px;
            top: 16px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: -8px 3px 0 0 rgba(255, 255, 255, 0.75), 8px -3px 0 0 rgba(255, 255, 255, 0.75);
        }

        .brand-name {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 1.62rem;
            font-weight: 700;
            color: #f8fafc;
            display: block;
            letter-spacing: 0.01em;
        }

        .brand-name span {
            color: #67e8f9;
        }

        .brand-sub {
            font-size: 0.84rem;
            color: #94a3b8;
        }

        .auth-card {
            background: linear-gradient(158deg, rgba(8, 47, 73, 0.46), rgba(15, 23, 42, 0.72));
            border-radius: 22px;
            padding: 2rem;
            border: 1px solid rgba(125, 211, 252, 0.24);
            box-shadow: 0 18px 55px rgba(2, 6, 23, 0.58);
            backdrop-filter: blur(14px);
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(186, 230, 253, 0.16) 50%, transparent 70%);
            transform: translateX(-120%);
            animation: scan-shine 6s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes scan-shine {
            0% { transform: translateX(-120%); }
            35%, 100% { transform: translateX(120%); }
        }

        .auth-card h2 {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 1.28rem;
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 0.35rem;
            letter-spacing: 0.02em;
            position: relative;
            z-index: 1;
        }

        .auth-card p {
            font-size: 0.87rem;
            color: #94a3b8;
            margin-bottom: 1.45rem;
            position: relative;
            z-index: 1;
        }

        .form-label {
            font-size: 0.76rem;
            font-weight: 700;
            color: #bae6fd;
            margin-bottom: 0.42rem;
            display: block;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .form-control {
            border-radius: 12px;
            border: 1.5px solid rgba(125, 211, 252, 0.22);
            font-size: 0.92rem;
            padding: 0.68rem 0.9rem;
            color: #f8fafc;
            width: 100%;
            font-family: 'Manrope', sans-serif;
            background: rgba(8, 47, 73, 0.4);
            transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s;
        }

        .form-control::placeholder {
            color: #7dd3fc;
            opacity: 0.62;
        }

        .form-control:focus {
            border-color: #22d3ee;
            box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.2), 0 8px 20px rgba(14, 116, 144, 0.25);
            outline: none;
            background: rgba(8, 47, 73, 0.58);
        }

        .form-control.is-invalid {
            border-color: #fda4af;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            color: #fecdd3;
            margin-top: 0.3rem;
            display: block;
        }

        .btn-auth {
            width: 100%;
            border: 1px solid rgba(125, 211, 252, 0.36);
            background: linear-gradient(135deg, #0891b2, #0284c7 45%, #0f766e);
            color: #ecfeff;
            padding: 0.74rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            font-family: 'Chakra Petch', sans-serif;
            cursor: pointer;
            letter-spacing: 0.03em;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
            box-shadow: 0 10px 25px rgba(8, 145, 178, 0.35);
            margin-top: 1.2rem;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(8, 145, 178, 0.45);
            filter: saturate(1.12);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.86rem;
            color: #cbd5e1;
        }

        .auth-footer a {
            color: #67e8f9;
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert-error {
            background: rgba(127, 29, 29, 0.42);
            color: #fecaca;
            border: 1px solid rgba(252, 165, 165, 0.35);
            border-radius: 12px;
            padding: 0.7rem 0.95rem;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .hint {
            font-size: 0.79rem;
            color: #a5f3fc;
            opacity: 0.86;
            margin-top: 0.26rem;
        }

        .travel-lane {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            height: 74px;
            pointer-events: none;
            z-index: 2;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0), rgba(148, 163, 184, 0.16));
        }

        .travel-lane::before {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 14px;
            height: 4px;
            background: repeating-linear-gradient(90deg, rgba(100, 116, 139, 0.26) 0 12px, rgba(100, 116, 139, 0) 12px 24px);
        }

        .travel-lane::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(120px 14px at 18% 56px, rgba(100, 116, 139, 0.16), transparent 70%), radial-gradient(150px 14px at 56% 56px, rgba(100, 116, 139, 0.14), transparent 70%), radial-gradient(120px 14px at 84% 56px, rgba(100, 116, 139, 0.14), transparent 70%);
        }

        .journey-item {
            position: absolute;
            color: #475569;
            opacity: 0.82;
            will-change: transform;
        }

        .journey-car {
            bottom: 19px;
            font-size: 1.08rem;
            animation: journey-east 24s linear infinite;
        }

        .journey-bus {
            bottom: 19px;
            font-size: 1.06rem;
            animation: journey-east 34s linear infinite;
            animation-delay: -14s;
        }

        .journey-bike {
            bottom: 20px;
            font-size: 1.02rem;
            animation: journey-west 22s linear infinite;
            animation-delay: -9s;
        }

        .journey-hiker {
            bottom: 19px;
            font-size: 1.02rem;
            animation: journey-west 18s linear infinite, hiker-bounce 0.7s ease-in-out infinite;
            animation-delay: -5s;
        }

        .journey-plane {
            top: 10px;
            font-size: 0.95rem;
            color: #0e7490;
            opacity: 0.6;
            animation: sky-fly 30s ease-in-out infinite;
        }

        .journey-cloud-1 {
            top: 8px;
            font-size: 0.86rem;
            opacity: 0.32;
            animation: cloud-drift 42s linear infinite;
        }

        .journey-cloud-2 {
            top: 20px;
            font-size: 0.72rem;
            opacity: 0.24;
            animation: cloud-drift 56s linear infinite;
            animation-delay: -18s;
        }

        @keyframes journey-east {
            0% { transform: translateX(-12vw) translateY(0); }
            25% { transform: translateX(20vw) translateY(-1px); }
            50% { transform: translateX(50vw) translateY(1px); }
            75% { transform: translateX(80vw) translateY(-1px); }
            100% { transform: translateX(112vw) translateY(0); }
        }

        @keyframes journey-west {
            0% { transform: translateX(110vw) translateY(0); }
            25% { transform: translateX(78vw) translateY(-1px); }
            50% { transform: translateX(48vw) translateY(1px); }
            75% { transform: translateX(20vw) translateY(-1px); }
            100% { transform: translateX(-14vw) translateY(0); }
        }

        @keyframes hiker-bounce {
            0%, 100% { margin-bottom: 0; }
            50% { margin-bottom: 1px; }
        }

        @keyframes sky-fly {
            0% { transform: translateX(-14vw) translateY(8px) rotate(-6deg); }
            35% { transform: translateX(28vw) translateY(-6px) rotate(-2deg); }
            70% { transform: translateX(74vw) translateY(-2px) rotate(3deg); }
            100% { transform: translateX(112vw) translateY(7px) rotate(5deg); }
        }

        @keyframes cloud-drift {
            0% { transform: translateX(-20vw); }
            100% { transform: translateX(120vw); }
        }

        @media (max-width: 640px) {
            .travel-lane {
                height: 62px;
            }

            .journey-plane,
            .journey-cloud-2 {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .journey-item {
                animation: none !important;
            }
        }

        .brand-chip {
            color: #0e7490;
            border-color: rgba(14, 116, 144, 0.24);
            background: rgba(255, 255, 255, 0.76);
        }

        .brand-name {
            color: #0f172a;
        }

        .brand-name span {
            color: #0f766e;
        }

        .brand-icon {
            background: linear-gradient(140deg, #0f766e, #0e7490 56%, #155e75);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.35);
        }

        body {
            background:
                radial-gradient(circle at 16% 18%, rgba(110, 231, 183, 0.15), transparent 38%),
                radial-gradient(circle at 84% 14%, rgba(125, 211, 252, 0.16), transparent 42%),
                linear-gradient(160deg, #f7f8f4, #eef3ed 52%, #f9f7ef) !important;
            color: #1f2937;
        }

        .scene-grid {
            background-image: linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
        }

        .scene-orb {
            display: none;
        }

        .brand-sub,
        .auth-footer,
        .auth-card p {
            color: #64748b;
        }

        .auth-card {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.9), rgba(247, 249, 246, 0.9));
            border: 1px solid rgba(148, 163, 184, 0.2);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        }

        .auth-card h2,
        .form-control,
        .form-label {
            color: #0f172a;
        }

        .form-label {
            color: #475569;
        }

        .form-control {
            background: #ffffff;
            border-color: rgba(148, 163, 184, 0.26);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12), 0 8px 18px rgba(15, 23, 42, 0.08);
            background: #ffffff;
        }

        .btn-auth {
            border: 1px solid rgba(14, 116, 144, 0.34);
            background: linear-gradient(135deg, #0f766e, #0e7490 45%, #155e75);
            color: #f8fafc;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.14);
        }

        .btn-auth:hover {
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.2);
            filter: saturate(1.03);
        }

        .auth-footer a {
            color: #0e7490;
        }

        .hint {
            color: #64748b;
        }

        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }

            .auth-card {
                padding: 1.35rem;
                border-radius: 18px;
            }

            .brand-name {
                font-size: 1.42rem;
            }

            .brand-chip {
                font-size: 0.63rem;
            }
        }
    </style>
</head>
<body>
<div class="scene-grid" aria-hidden="true"></div>
<div class="scene-orb scene-orb-1" aria-hidden="true"></div>
<div class="scene-orb scene-orb-2" aria-hidden="true"></div>
<div class="travel-lane" aria-hidden="true">
    <i class="bi bi-cloud-fill journey-item journey-cloud-1"></i>
    <i class="bi bi-cloud-fill journey-item journey-cloud-2"></i>
    <i class="bi bi-airplane-fill journey-item journey-plane"></i>
    <i class="bi bi-car-front-fill journey-item journey-car"></i>
    <i class="bi bi-bus-front-fill journey-item journey-bus"></i>
    <i class="bi bi-bicycle journey-item journey-bike"></i>
    <i class="bi bi-person-walking journey-item journey-hiker"></i>
</div>
<div class="auth-wrapper">
    <div class="brand">
        <div class="brand-icon" aria-hidden="true"></div>
        <span class="brand-name">Split<span>Money</span></span>
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
