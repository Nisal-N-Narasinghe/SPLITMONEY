<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — SplitMoney</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(circle at 14% 20%, rgba(110, 231, 183, 0.14), transparent 35%),
                radial-gradient(circle at 88% 14%, rgba(125, 211, 252, 0.14), transparent 34%),
                linear-gradient(160deg, #f7f8f4, #eef3ed 52%, #f9f7ef);
            min-height: 100vh;
            color: #1f2937;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }

        .admin-grid-overlay {
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 52px 52px;
            mask-image: radial-gradient(circle at center, black 42%, transparent 78%);
        }

        .admin-topbar {
            background: linear-gradient(125deg, rgba(255, 255, 255, 0.9), rgba(244, 248, 244, 0.9));
            padding: 0.82rem 1.35rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.09);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            backdrop-filter: blur(12px);
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            color: #0f172a;
            text-decoration: none;
            font-family: 'Chakra Petch', sans-serif;
            font-size: 1.08rem;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .topbar-brand .brand-mark {
            width: 30px;
            height: 30px;
            border-radius: 10px;
            background: linear-gradient(140deg, #2dd4bf, #0284c7 52%, #14b8a6);
            box-shadow: 0 7px 16px rgba(20, 184, 166, 0.34);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .topbar-brand .brand-mark::before {
            content: '';
            position: absolute;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.92);
            left: 6px;
            top: 9px;
        }

        .topbar-brand .brand-mark::after {
            content: '';
            position: absolute;
            width: 2px;
            height: 14px;
            right: 10px;
            top: 9px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: -4px 2px 0 0 rgba(255, 255, 255, 0.74), 4px -2px 0 0 rgba(255, 255, 255, 0.74);
        }

        .topbar-brand .brand-word span {
            color: #0f766e;
        }

        .admin-badge {
            background: rgba(15, 118, 110, 0.12);
            color: #0f766e;
            border: 1px solid rgba(14, 116, 144, 0.26);
            border-radius: 999px;
            padding: 0.2rem 0.6rem;
            font-size: 0.64rem;
            font-weight: 700;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.68rem;
        }

        .topbar-user {
            color: #334155;
            font-size: 0.84rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .topbar-user i {
            color: #0f766e;
        }

        .btn-topbar {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.24);
            color: #334155;
            border-radius: 9px;
            padding: 0.35rem 0.72rem;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Manrope', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: transform 0.15s, background 0.2s, color 0.2s;
        }

        .btn-topbar:hover {
            background: rgba(226, 232, 240, 0.75);
            color: #0f172a;
            transform: translateY(-1px);
        }

        .admin-layout {
            display: flex;
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .admin-sidebar {
            width: 232px;
            background: linear-gradient(175deg, rgba(255, 255, 255, 0.86), rgba(247, 249, 246, 0.88));
            border-right: 1px solid rgba(148, 163, 184, 0.2);
            padding: 1.3rem 0;
            flex-shrink: 0;
            min-height: calc(100vh - 58px);
            backdrop-filter: blur(12px);
        }

        .sidebar-section {
            padding: 0 0.75rem;
            margin-bottom: 0.6rem;
        }

        .sidebar-label {
            font-size: 0.66rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: #64748b;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.3rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.58rem 0.75rem;
            border-radius: 11px;
            color: #334155;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            transition: background 0.2s, color 0.2s, transform 0.18s;
            margin-bottom: 3px;
            border: 1px solid transparent;
        }

        .sidebar-link:hover {
            background: rgba(226, 232, 240, 0.6);
            color: #0f172a;
            transform: translateX(2px);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(15, 118, 110, 0.1), rgba(14, 116, 144, 0.1));
            color: #0f172a;
            border-color: rgba(14, 116, 144, 0.24);
            box-shadow: inset 0 0 0 1px rgba(14, 116, 144, 0.1);
        }

        .sidebar-link.active i {
            color: #0f766e;
        }

        .sidebar-link i {
            width: 18px;
            text-align: center;
            font-size: 0.95rem;
            color: #64748b;
        }

        .admin-main {
            flex: 1;
            padding: 1.7rem;
            max-width: 100%;
            overflow-x: auto;
        }

        .admin-main > * {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.9), rgba(247, 249, 246, 0.9));
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 18px;
            padding: 1.2rem;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(8px);
        }

        .travel-lane {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            height: 74px;
            pointer-events: none;
            z-index: 3;
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

        @media (max-width: 992px) {
            .topbar-right {
                gap: 0.5rem;
            }

            .topbar-user {
                display: none;
            }
        }

        @media (max-width: 820px) {
            .admin-layout {
                flex-direction: column;
            }

            .admin-sidebar {
                width: 100%;
                min-height: auto;
                border-right: none;
                border-bottom: 1px solid rgba(125, 211, 252, 0.2);
                padding: 0.8rem;
            }

            .sidebar-section {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 0.38rem;
            }

            .sidebar-label {
                width: 100%;
                padding-left: 0.2rem;
                margin-bottom: 0;
            }

            .sidebar-link {
                flex: 1 1 auto;
                min-width: 130px;
                justify-content: center;
            }

            .admin-main {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="admin-grid-overlay" aria-hidden="true"></div>
<div class="travel-lane" aria-hidden="true">
    <i class="bi bi-cloud-fill journey-item journey-cloud-1"></i>
    <i class="bi bi-cloud-fill journey-item journey-cloud-2"></i>
    <i class="bi bi-airplane-fill journey-item journey-plane"></i>
    <i class="bi bi-car-front-fill journey-item journey-car"></i>
    <i class="bi bi-bus-front-fill journey-item journey-bus"></i>
    <i class="bi bi-bicycle journey-item journey-bike"></i>
    <i class="bi bi-person-walking journey-item journey-hiker"></i>
</div>

<div class="admin-topbar">
    <div style="display:flex;align-items:center;gap:10px;">
        <a href="/admin" class="topbar-brand">
            <span class="brand-mark" aria-hidden="true"></span>
            <span class="brand-word">Split<span>Money</span></span>
        </a>
        <span class="admin-badge">Admin</span>
    </div>
    <div class="topbar-right">
        <span class="topbar-user">
            <i class="bi bi-shield-fill-check"></i>
            {{ Auth::user()->name }}
        </span>
        <a href="/" class="btn-topbar"><i class="bi bi-house"></i> App</a>
        <form method="POST" action="/logout" style="margin:0;">
            @csrf
            <button type="submit" class="btn-topbar">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="sidebar-section">
            <div class="sidebar-label">Overview</div>
            <a href="/admin" class="sidebar-link {{ request()->is('admin') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-label">Manage</div>
            <a href="/admin/users" class="sidebar-link {{ request()->is('admin/users') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Users
            </a>
            <a href="/admin/groups" class="sidebar-link {{ request()->is('admin/groups') ? 'active' : '' }}">
                <i class="bi bi-collection-fill"></i> Groups
            </a>
        </div>
    </aside>

    <main class="admin-main">
        @yield('content')

        <style>
        /* Shared reduced-color admin skin */
        .admin-main .page-title,
        .admin-main h1,
        .admin-main .section-title,
        .admin-main .stat-value,
        .admin-main .group-name,
        .admin-main .user-name,
        .admin-main .user-name-cell {
            color: #0f172a !important;
            font-family: 'Chakra Petch', sans-serif !important;
            letter-spacing: 0.01em;
        }

        .admin-main .users-card,
        .admin-main .groups-card,
        .admin-main .section-card,
        .admin-main .stat-card {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.9), rgba(247, 249, 246, 0.9)) !important;
            border-color: rgba(148, 163, 184, 0.2) !important;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08) !important;
        }

        .admin-main .users-table thead th,
        .admin-main .groups-table thead th {
            background: rgba(148, 163, 184, 0.12) !important;
            color: #475569 !important;
            border-bottom-color: rgba(148, 163, 184, 0.2) !important;
        }

        .admin-main .users-table tbody td,
        .admin-main .groups-table tbody td,
        .admin-main .user-email,
        .admin-main .user-date,
        .admin-main .badge-date,
        .admin-main .stat-label,
        .admin-main .empty-state {
            color: #64748b !important;
            border-bottom-color: rgba(148, 163, 184, 0.18) !important;
        }

        .admin-main .users-table tbody tr:hover td,
        .admin-main .groups-table tbody tr:hover td,
        .admin-main .user-row:hover {
            background: rgba(226, 232, 240, 0.6) !important;
        }

        .admin-main .user-avatar,
        .admin-main .group-icon,
        .admin-main .stat-icon {
            background: rgba(15, 118, 110, 0.12) !important;
            color: #0f766e !important;
        }

        .admin-main .count-badge {
            background: rgba(14, 116, 144, 0.1) !important;
            color: #0e7490 !important;
            border: 1px solid rgba(14, 116, 144, 0.22) !important;
        }

        .admin-main .btn-del {
            background: rgba(127, 29, 29, 0.4) !important;
            color: #fecaca !important;
            border: 1px solid rgba(252, 165, 165, 0.36) !important;
        }

        .admin-main .btn-del:hover {
            background: rgba(185, 28, 28, 0.5) !important;
        }

        .admin-main .stat-icon.blue,
        .admin-main .stat-icon.green,
        .admin-main .stat-icon.orange,
        .admin-main .stat-icon.purple {
            background: rgba(15, 118, 110, 0.12) !important;
            color: #0f766e !important;
        }
        </style>
    </main>
</div>

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
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<style>
    .swal2-popup { font-family: 'Inter', sans-serif !important; border-radius: 16px !important; }
    .swal2-title { font-size: 1.15rem !important; font-weight: 700 !important; }
    .swal2-html-container { font-size: 0.9rem !important; }
    .swal2-confirm { border-radius: 10px !important; font-weight: 600 !important; font-size: 0.88rem !important; padding: 0.55rem 1.2rem !important; }
    .swal2-cancel { border-radius: 10px !important; font-weight: 600 !important; font-size: 0.88rem !important; padding: 0.55rem 1.2rem !important; }
    .swal2-toast { border-radius: 12px !important; font-family: 'Inter', sans-serif !important; }
</style>
</body>
</html>
