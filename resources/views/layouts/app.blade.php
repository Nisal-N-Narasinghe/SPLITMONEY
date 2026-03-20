<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SplitMoney</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="{{ asset('css/user.css') }}" rel="stylesheet">

        <style>
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        html,
        body {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(circle at 14% 20%, rgba(110, 231, 183, 0.14), transparent 36%),
                radial-gradient(circle at 86% 16%, rgba(125, 211, 252, 0.16), transparent 38%),
                linear-gradient(160deg, #f7f8f4, #eef3ed 52%, #f9f7ef);
            color: #1f2937;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image: linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 52px 52px;
            mask-image: radial-gradient(circle at center, black 38%, transparent 80%);
        }

        .navbar {
            background: linear-gradient(125deg, rgba(255, 255, 255, 0.9), rgba(244, 248, 244, 0.9));
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
            padding: 0.95rem 1rem;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            position: relative;
            z-index: 10;
        }

        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 0.55rem;
            text-decoration: none;
        }

        .brand-mark {
            width: 30px;
            height: 30px;
            border-radius: 10px;
            background: linear-gradient(140deg, #38bdf8, #2563eb 52%, #0ea5e9);
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 16px rgba(14, 165, 233, 0.35);
            overflow: hidden;
        }

        .brand-mark::before {
            content: '';
            position: absolute;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.92);
            left: 5px;
            top: 8px;
        }

        .brand-mark::after {
            content: '';
            position: absolute;
            width: 2px;
            height: 14px;
            right: 11px;
            top: 8px;
            background: rgba(255, 255, 255, 0.88);
            border-radius: 4px;
            box-shadow: -4px 2px 0 0 rgba(255, 255, 255, 0.72), 4px -2px 0 0 rgba(255, 255, 255, 0.72);
            animation: brand-pulse 2s ease-in-out infinite;
        }

        .brand-word {
            color: #0f172a;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .brand-word span {
            color: #0f766e;
        }

        @keyframes brand-pulse {

            0%,
            100% {
                filter: drop-shadow(0 0 5px rgba(139, 92, 246, 0.5));
            }

            50% {
                filter: drop-shadow(0 0 15px rgba(139, 92, 246, 0.8));
            }
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #334155;
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.78);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        .navbar-user i {
            font-size: 1.2rem;
            color: #5eead4;
        }

        .btn-logout {
            background: linear-gradient(135deg, rgba(15, 118, 110, 0.12), rgba(14, 116, 144, 0.12));
            border: 1px solid rgba(14, 116, 144, 0.26);
            color: #0f172a;
            border-radius: 20px;
            padding: 0.4rem 1rem;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Manrope', sans-serif;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s cubic-bezier(.4, 0, .2, 1);
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, rgba(15, 118, 110, 0.2), rgba(14, 116, 144, 0.2));
            border-color: rgba(14, 116, 144, 0.4);
            color: #0f172a;
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
        }

        .btn-logout:active {
            transform: translateY(-1px);
        }

        .main-content {
            max-width: 1020px;
            margin: 2.5rem auto;
            padding: 0 1rem;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .main-content {
                margin: 1.5rem auto;
            }
        }

        .alert {
            border-radius: 16px;
            border: none;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(74, 222, 128, 0.15), rgba(34, 197, 94, 0.15));
            color: #166534;
            border: 1px solid rgba(74, 222, 128, 0.3);
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

        <div class="travel-lane" aria-hidden="true">
            <i class="bi bi-cloud-fill journey-item journey-cloud-1"></i>
            <i class="bi bi-cloud-fill journey-item journey-cloud-2"></i>
            <i class="bi bi-airplane-fill journey-item journey-plane"></i>
            <i class="bi bi-car-front-fill journey-item journey-car"></i>
            <i class="bi bi-bus-front-fill journey-item journey-bus"></i>
            <i class="bi bi-bicycle journey-item journey-bike"></i>
            <i class="bi bi-person-walking journey-item journey-hiker"></i>
        </div>

        <nav class="navbar navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <span class="brand-mark" aria-hidden="true"></span>
                    <span class="brand-word">Split<span>Money</span></span>
                </a>
                @auth
                <div class="d-flex align-items-center gap-3">
                    @if(Auth::user()->is_admin)
                    <a href="/admin" class="btn-logout"
                        style="text-decoration:none;background:rgba(251,191,36,0.15);border-color:rgba(251,191,36,0.3);color:#fbbf24;">
                        <i class="bi bi-shield-fill-check"></i> Dashboard
                    </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="btn-logout"
                        style="text-decoration:none;background:rgba(15,118,110,0.12);border-color:rgba(15,118,110,0.24);color:#0f172a;">
                         <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <form method="POST" action="/logout" class="m-0">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </nav>

        <div class="main-content">

            @yield('content')

            <style>
            /* Shared futuristic skin for user dashboard views */
            .main-content .page-header {
                border-bottom-color: rgba(148, 163, 184, 0.2) !important;
            }

            .main-content .page-title,
            .main-content .planner-title {
                font-family: 'Chakra Petch', sans-serif !important;
                background: linear-gradient(90deg, #0f172a, #0f766e) !important;
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent !important;
                background-clip: text !important;
            }

            .main-content .page-subtitle,
            .main-content .planner-subtitle,
            .main-content .muted-note {
                color: #94a3b8 !important;
            }

            .main-content .back-btn {
                background: linear-gradient(135deg, rgba(15, 118, 110, 0.12), rgba(14, 116, 144, 0.12)) !important;
                border-color: rgba(14, 116, 144, 0.26) !important;
                color: #0f172a !important;
            }

            .main-content .back-btn:hover {
                background: linear-gradient(135deg, rgba(15, 118, 110, 0.2), rgba(14, 116, 144, 0.2)) !important;
                border-color: rgba(14, 116, 144, 0.4) !important;
            }

            .main-content .form-card,
            .main-content .section-card,
            .main-content .group-card,
            .main-content .empty-state,
            .main-content .planner-card {
                background: linear-gradient(160deg, rgba(255, 255, 255, 0.88), rgba(247, 249, 246, 0.88)) !important;
                border-color: rgba(148, 163, 184, 0.2) !important;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08) !important;
                backdrop-filter: blur(10px) !important;
            }

            .main-content .group-card-name,
            .main-content .section-title,
            .main-content .balance-name,
            .main-content .planner-label,
            .main-content .budget-value,
            .main-content .day-title {
                color: #0f172a !important;
            }

            .main-content .group-card-meta,
            .main-content .budget-label,
            .main-content .day-meta,
            .main-content .expense-item,
            .main-content .member-email {
                color: #94a3b8 !important;
            }

            .main-content .form-control,
            .main-content .planner-input,
            .main-content .planner-select,
            .main-content .planner-textarea,
            .main-content .member-check-item,
            .main-content .member-option,
            .main-content .members-checkbox-list,
            .main-content .itinerary-day,
            .main-content .budget-box {
                background: #ffffff !important;
                border-color: rgba(148, 163, 184, 0.26) !important;
                color: #0f172a !important;
            }

            .main-content .form-control::placeholder,
            .main-content .planner-input::placeholder,
            .main-content .planner-textarea::placeholder {
                color: #94a3b8 !important;
                opacity: 0.68;
            }

            .main-content .form-control:focus,
            .main-content .planner-input:focus,
            .main-content .planner-select:focus,
            .main-content .planner-textarea:focus {
                border-color: #0f766e !important;
                background: #ffffff !important;
                box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12), 0 8px 20px rgba(15, 23, 42, 0.08) !important;
            }

            .main-content .btn-create,
            .main-content .btn-submit,
            .main-content .planner-btn,
            .main-content .btn-expense {
                background: linear-gradient(135deg, #0f766e, #0e7490 45%, #155e75) !important;
                border: 1px solid rgba(14, 116, 144, 0.35) !important;
                color: #f8fafc !important;
                box-shadow: 0 10px 25px rgba(15, 23, 42, 0.14) !important;
                font-family: 'Chakra Petch', sans-serif !important;
            }

            .main-content .btn-create:hover,
            .main-content .btn-submit:hover,
            .main-content .planner-btn:hover,
            .main-content .btn-expense:hover {
                box-shadow: 0 14px 32px rgba(15, 23, 42, 0.18) !important;
                filter: saturate(1.02);
            }

            .main-content .btn-settlement {
                background: linear-gradient(135deg, #0e7490, #155e75 45%, #0f766e) !important;
                border: 1px solid rgba(14, 116, 144, 0.3) !important;
                color: #f8fafc !important;
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.14) !important;
                font-family: 'Chakra Petch', sans-serif !important;
            }

            .main-content .btn-delete-card,
            .main-content .btn-delete-group {
                background: rgba(127, 29, 29, 0.4) !important;
                border-color: rgba(252, 165, 165, 0.4) !important;
                color: #fecaca !important;
            }

            .main-content .member-pill,
            .main-content .you-badge,
            .main-content .ai-badge {
                background: linear-gradient(135deg, rgba(15, 118, 110, 0.12), rgba(14, 116, 144, 0.12)) !important;
                border-color: rgba(14, 116, 144, 0.26) !important;
                color: #0f766e !important;
            }

            .main-content .balance-row,
            .main-content .data-table tbody td,
            .main-content .data-table thead th {
                border-bottom-color: rgba(148, 163, 184, 0.18) !important;
            }

            .main-content .data-table thead th {
                background: rgba(148, 163, 184, 0.12) !important;
                color: #475569 !important;
            }

            .main-content .data-table tbody td,
            .main-content .amount-cell,
            .main-content .member-name {
                color: #1e293b !important;
            }

            .main-content .data-table tbody tr:hover td {
                background: rgba(226, 232, 240, 0.6) !important;
            }

            .main-content .badge-gets {
                background: rgba(220, 252, 231, 0.9) !important;
                color: #6ee7b7 !important;
                border-color: rgba(16, 185, 129, 0.24) !important;
            }

            .main-content .badge-owes {
                background: rgba(127, 29, 29, 0.4) !important;
                color: #fecaca !important;
                border-color: rgba(252, 165, 165, 0.4) !important;
            }

            .main-content .badge-settled {
                background: rgba(224, 242, 254, 0.85) !important;
                color: #0e7490 !important;
                border-color: rgba(14, 116, 144, 0.24) !important;
            }

            .table-wrapper {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 10px;
            }

            .table-wrapper::-webkit-scrollbar {
                height: 6px;
            }

            .table-wrapper::-webkit-scrollbar-track {
                background: rgba(148, 163, 184, 0.1);
                border-radius: 3px;
            }

            .table-wrapper::-webkit-scrollbar-thumb {
                background: rgba(148, 163, 184, 0.3);
                border-radius: 3px;
            }

            .table-wrapper::-webkit-scrollbar-thumb:hover {
                background: rgba(148, 163, 184, 0.5);
            }

            @media (max-width: 768px) {
                .main-content .page-title,
                .main-content .planner-title {
                    font-size: 1.5rem !important;
                }

                .table-wrapper table {
                    min-width: 640px;
                }
            }
            </style>

        </div>

        @auth
        <a href="/trip-planner" class="ai-fab" title="Plan Your Next Trip" aria-label="Open AI Trip Planner">
            <span class="ai-fab-icon">
                <i class="bi bi-signpost-split-fill"></i>
            </span>
            <span class="ai-fab-label-wrap">
                <span class="ai-fab-kicker">Trip Planner</span>
                <span class="ai-fab-label">Plan Trip</span>
            </span>
        </a>
        <style>
        .ai-fab {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 1050;
            display: grid;
            grid-template-columns: auto;
            align-items: center;
            gap: 0;
            text-decoration: none;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(247, 249, 246, 0.95));
            border: 1px solid rgba(148, 163, 184, 0.28);
            border-radius: 18px;
            padding: 8px;
            width: 64px;
            height: 64px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            box-shadow: 0 14px 24px rgba(15, 23, 42, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.55);
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1), transform 0.25s ease, box-shadow 0.25s ease, filter 0.25s ease;
            animation: fab-drift 4.5s ease-in-out infinite;
        }

        .ai-fab::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 26%, rgba(255, 255, 255, 0.24) 48%, transparent 70%);
            transform: translateX(-115%);
            animation: fab-shine 4.8s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes fab-shine {
            0% {
                transform: translateX(-115%);
            }

            40%,
            100% {
                transform: translateX(130%);
            }
        }

        @keyframes fab-drift {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }
        }

        .ai-fab:hover {
            width: 192px;
            grid-template-columns: auto 1fr;
            gap: 0.62rem;
            padding: 8px 10px 8px 8px;
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 18px 30px rgba(15, 23, 42, 0.14), inset 0 1px 0 rgba(255, 255, 255, 0.65);
            filter: saturate(1.02);
        }

        .ai-fab:focus-visible {
            outline: 3px solid rgba(56, 189, 248, 0.65);
            outline-offset: 3px;
        }

        .ai-fab:active {
            transform: translateY(-1px) scale(0.98);
        }

        .ai-fab-glow {
            position: absolute;
            left: 8px;
            top: 50%;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            transform: translateY(-50%);
            background: radial-gradient(circle, rgba(103, 232, 249, 0.34), rgba(56, 189, 248, 0.06) 68%, transparent 74%);
            pointer-events: none;
        }

        .ai-fab-orbit {
            position: absolute;
            left: 7px;
            top: 50%;
            width: 50px;
            height: 50px;
            transform: translateY(-50%);
            border-radius: 50%;
            border: 1px dashed rgba(186, 230, 253, 0.42);
            animation: fab-orbit 8s linear infinite;
            pointer-events: none;
        }

        .ai-fab-orbit-2 {
            width: 42px;
            height: 42px;
            left: 11px;
            border-color: rgba(110, 231, 183, 0.42);
            animation-direction: reverse;
            animation-duration: 6.2s;
        }

        @keyframes fab-orbit {
            0% {
                transform: translateY(-50%) rotate(0deg);
            }

            100% {
                transform: translateY(-50%) rotate(360deg);
            }
        }

        .ai-fab-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.28rem;
            color: #0f766e;
            position: relative;
            z-index: 1;
            background: linear-gradient(145deg, rgba(15, 118, 110, 0.12), rgba(14, 116, 144, 0.12));
            border: 1px solid rgba(14, 116, 144, 0.2);
            box-shadow: inset 0 1px 3px rgba(255, 255, 255, 0.32);
        }

        .ai-fab-label-wrap {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            line-height: 1.05;
            opacity: 0;
            width: 0;
            transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1), width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .ai-fab:hover .ai-fab-label-wrap {
            opacity: 1;
            width: auto;
        }

        .ai-fab-kicker {
            font-family: 'Poppins', sans-serif;
            font-size: 0.63rem;
            letter-spacing: 0.11em;
            text-transform: uppercase;
            color: #0e7490;
            margin-bottom: 0.2rem;
            font-weight: 700;
        }

        .ai-fab-label {
            color: #0f172a;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            white-space: nowrap;
            letter-spacing: 0.02em;
        }

        .ai-fab-arrow {
            position: relative;
            z-index: 1;
            width: 28px;
            height: 28px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #f0f9ff;
            background: rgba(240, 249, 255, 0.2);
            border: 1px solid rgba(240, 249, 255, 0.34);
            transition: transform 0.22s ease;
            font-size: 0.9rem;
        }

        .ai-fab:hover .ai-fab-arrow {
            transform: translate(2px, -2px);
        }

        @media (max-width: 640px) {
            .ai-fab {
                bottom: 16px;
                right: 16px;
                width: 56px;
                height: 56px;
                border-radius: 16px;
                padding: 6px;
            }

            .ai-fab:hover {
                width: 160px;
                padding: 6px 8px 6px 6px;
            }

            .ai-fab-icon {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                font-size: 1.08rem;
            }

            .ai-fab-orbit {
                width: 44px;
                height: 44px;
                left: 5px;
            }

            .ai-fab-orbit-2 {
                width: 36px;
                height: 36px;
                left: 9px;
            }

            .ai-fab-kicker {
                display: none;
            }

            .ai-fab-label {
                font-size: 0.86rem;
            }

            .ai-fab-arrow {
                width: 24px;
                height: 24px;
                border-radius: 8px;
                font-size: 0.82rem;
            }
        }
        </style>
        @endauth

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: @json(session('success')),
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        @endif

        @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: @json(session('error')),
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
        @endif

        document.querySelectorAll('form[data-confirm]').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = form.dataset.confirm;
                const title = form.dataset.title || 'Are you sure?';
                Swal.fire({
                    title: title,
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                    borderRadius: '16px',
                    customClass: {
                        popup: 'swal-custom-popup',
                        confirmButton: 'swal-confirm-btn',
                        cancelButton: 'swal-cancel-btn',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
        </script>
        <style>
        .swal2-popup {
            font-family: 'Inter', sans-serif !important;
            border-radius: 16px !important;
        }

        .swal2-title {
            font-size: 1.15rem !important;
            font-weight: 700 !important;
        }

        .swal2-html-container {
            font-size: 0.9rem !important;
        }

        .swal2-confirm {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 0.88rem !important;
            padding: 0.55rem 1.2rem !important;
        }

        .swal2-cancel {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 0.88rem !important;
            padding: 0.55rem 1.2rem !important;
        }

        .swal2-toast {
            border-radius: 12px !important;
            font-family: 'Inter', sans-serif !important;
        }
        </style>
    </body>

</html>
