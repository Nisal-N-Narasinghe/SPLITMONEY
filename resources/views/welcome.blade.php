<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SplitMoney</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: #1f2937;
            background:
                radial-gradient(circle at 14% 18%, rgba(110, 231, 183, 0.14), transparent 32%),
                radial-gradient(circle at 82% 14%, rgba(125, 211, 252, 0.14), transparent 35%),
                linear-gradient(160deg, #f7f8f4, #eef3ed 52%, #f9f7ef);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .grid-overlay {
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: radial-gradient(circle at center, black 40%, transparent 78%);
        }

        .hero {
            width: 100%;
            max-width: 920px;
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.9), rgba(247, 249, 246, 0.9));
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }

        .top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.8rem;
            flex-wrap: wrap;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            color: #0f172a;
            text-decoration: none;
            font-family: 'Chakra Petch', sans-serif;
            font-weight: 700;
            letter-spacing: 0.01em;
            font-size: 1.2rem;
        }

        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 11px;
            background: linear-gradient(140deg, #2dd4bf, #0284c7 52%, #14b8a6);
            position: relative;
            overflow: hidden;
            box-shadow: 0 7px 16px rgba(14, 165, 233, 0.35);
            flex-shrink: 0;
        }

        .brand-mark::before {
            content: '';
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.92);
            left: 6px;
            top: 10px;
        }

        .brand-mark::after {
            content: '';
            position: absolute;
            width: 2px;
            height: 15px;
            right: 11px;
            top: 9px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 6px;
            box-shadow: -4px 2px 0 0 rgba(255, 255, 255, 0.74), 4px -2px 0 0 rgba(255, 255, 255, 0.74);
        }

        .brand span {
            color: #0f766e;
        }

        .auth-links {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .btn-ghost,
        .btn-main {
            border-radius: 10px;
            padding: 0.5rem 0.95rem;
            font-size: 0.84rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: transform 0.18s ease, background 0.2s ease, color 0.2s ease;
        }

        .btn-ghost {
            color: #334155;
            border: 1px solid rgba(148, 163, 184, 0.24);
            background: rgba(255, 255, 255, 0.8);
        }

        .btn-main {
            color: #f8fafc;
            border: 1px solid rgba(14, 116, 144, 0.34);
            background: linear-gradient(135deg, #0f766e, #0e7490 45%, #155e75);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.14);
            font-family: 'Chakra Petch', sans-serif;
        }

        .btn-ghost:hover,
        .btn-main:hover {
            transform: translateY(-1px);
        }

        .headline {
            font-family: 'Chakra Petch', sans-serif;
            font-size: clamp(1.7rem, 4vw, 2.7rem);
            line-height: 1.12;
            margin: 0 0 0.9rem;
            color: #0f172a;
            letter-spacing: 0.01em;
        }

        .headline span {
            color: #0f766e;
        }

        .sub {
            margin: 0;
            color: #64748b;
            max-width: 680px;
            line-height: 1.6;
            font-size: 0.98rem;
        }

        .meta-row {
            margin-top: 1.4rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }

        .meta-chip {
            background: rgba(14, 116, 144, 0.1);
            color: #0e7490;
            border: 1px solid rgba(14, 116, 144, 0.24);
            border-radius: 999px;
            padding: 0.32rem 0.72rem;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        @media (max-width: 640px) {
            .hero {
                padding: 1.2rem;
                border-radius: 18px;
            }
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
    </style>
</head>
<body>
<div class="grid-overlay" aria-hidden="true"></div>
<div class="travel-lane" aria-hidden="true">
    <i class="bi bi-cloud-fill journey-item journey-cloud-1"></i>
    <i class="bi bi-cloud-fill journey-item journey-cloud-2"></i>
    <i class="bi bi-airplane-fill journey-item journey-plane"></i>
    <i class="bi bi-car-front-fill journey-item journey-car"></i>
    <i class="bi bi-bus-front-fill journey-item journey-bus"></i>
    <i class="bi bi-bicycle journey-item journey-bike"></i>
    <i class="bi bi-person-walking journey-item journey-hiker"></i>
</div>

<section class="hero">
    <div class="top-row">
        <a href="/" class="brand">
            <span class="brand-mark" aria-hidden="true"></span>
            Split<span>Money</span>
        </a>

        @if (Route::has('login'))
        <div class="auth-links">
            @auth
            <a href="{{ url('/dashboard') }}" class="btn-main"><i class="bi bi-speedometer2"></i> Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="btn-ghost"><i class="bi bi-box-arrow-in-right"></i> Login</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn-main"><i class="bi bi-person-plus"></i> Register</a>
            @endif
            @endauth
        </div>
        @endif
    </div>

    <h1 class="headline">Split Expenses With A <span>Trip Planner</span> Mindset</h1>
    <p class="sub">Build groups, add expenses, settle balances, and launch AI-assisted trip planning in one clean flow. SplitMoney keeps the design focused and the money logic clear.</p>

    <div class="meta-row">
        <span class="meta-chip">Expense Splitting</span>
        <span class="meta-chip">Trip Planning</span>
        <span class="meta-chip">AI Assisted</span>
    </div>
</section>
</body>
</html>
