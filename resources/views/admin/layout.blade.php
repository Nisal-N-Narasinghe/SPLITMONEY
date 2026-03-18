<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — SplitMoney</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .topbar-brand i { color: #38bdf8; }

        .admin-badge {
            background: rgba(251,191,36,0.2);
            color: #fbbf24;
            border: 1px solid rgba(251,191,36,0.3);
            border-radius: 6px;
            padding: 0.15rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .topbar-user {
            color: #cbd5e1;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .topbar-user i { color: #fbbf24; }

        .btn-topbar {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            color: #cbd5e1;
            border-radius: 8px;
            padding: 0.3rem 0.7rem;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: background 0.15s;
        }

        .btn-topbar:hover { background: rgba(255,255,255,0.18); color: white; }

        .admin-layout {
            display: flex;
            flex: 1;
        }

        .admin-sidebar {
            width: 220px;
            background: white;
            border-right: 1px solid #e2e8f0;
            padding: 1.5rem 0;
            flex-shrink: 0;
            min-height: calc(100vh - 56px);
        }

        .sidebar-section {
            padding: 0 0.75rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.55rem 0.75rem;
            border-radius: 10px;
            color: #475569;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
        }

        .sidebar-link:hover { background: #f1f5f9; color: #0f172a; }

        .sidebar-link.active {
            background: #eff6ff;
            color: #2563eb;
            font-weight: 600;
        }

        .sidebar-link.active i { color: #2563eb; }

        .sidebar-link i {
            width: 18px;
            text-align: center;
            font-size: 0.95rem;
            color: #94a3b8;
        }

        .admin-main {
            flex: 1;
            padding: 2rem;
            max-width: 100%;
            overflow-x: auto;
        }
    </style>
</head>
<body>

<div class="admin-topbar">
    <div style="display:flex;align-items:center;gap:10px;">
        <a href="/admin" class="topbar-brand">
            <i class="bi bi-cash-coin"></i> SplitMoney
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
