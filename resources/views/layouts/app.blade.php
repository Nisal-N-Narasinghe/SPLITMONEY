<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SplitMoney</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            color: #1e293b;
        }

        .navbar {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
            padding: 0.9rem 1rem;
        }

        .navbar-brand {
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: #fff !important;
        }

        .navbar-brand i {
            color: #38bdf8;
            margin-right: 6px;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #cbd5e1;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .navbar-user i {
            font-size: 1.1rem;
            color: #38bdf8;
        }

        .btn-logout {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            color: #cbd5e1;
            border-radius: 8px;
            padding: 0.35rem 0.8rem;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s, color 0.15s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-logout:hover {
            background: rgba(255,255,255,0.18);
            color: white;
        }

        .main-content {
            max-width: 960px;
            margin: 2.5rem auto;
            padding: 0 1rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-cash-coin"></i>SplitMoney
        </a>
        @auth
        <div class="d-flex align-items-center gap-3">
            <div class="navbar-user">
                <i class="bi bi-person-circle"></i>
                <span>{{ Auth::user()->name }}</span>
            </div>
            @if(Auth::user()->is_admin)
            <a href="/admin" class="btn-logout" style="text-decoration:none;background:rgba(251,191,36,0.15);border-color:rgba(251,191,36,0.3);color:#fbbf24;">
                <i class="bi bi-shield-fill-check"></i> Admin
            </a>
            @endif
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

</div>

@auth
<a href="/trip-planner" class="ai-fab" title="AI Trip Planner">
    <span class="ai-fab-ring"></span>
    <span class="ai-fab-ring ai-fab-ring-2"></span>
    <span class="ai-fab-icon"><i class="bi bi-stars"></i></span>
    <span class="ai-fab-label">AI Planner</span>
</a>
<style>
    .ai-fab {
        position: fixed;
        bottom: 32px;
        right: 32px;
        z-index: 1050;
        display: flex;
        align-items: center;
        gap: 0;
        text-decoration: none;
        background: linear-gradient(135deg, #7c3aed, #4f46e5, #0ea5e9);
        background-size: 200% 200%;
        border-radius: 50px;
        padding: 0;
        width: 60px;
        height: 60px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(124,58,237,0.45), 0 2px 8px rgba(0,0,0,0.18);
        transition: width 0.35s cubic-bezier(.4,0,.2,1), border-radius 0.35s, padding 0.35s, box-shadow 0.2s;
        animation: fab-gradient 4s ease infinite;
    }

    @keyframes fab-gradient {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .ai-fab:hover {
        width: 170px;
        border-radius: 50px;
        padding-right: 20px;
        box-shadow: 0 12px 40px rgba(124,58,237,0.55), 0 4px 16px rgba(0,0,0,0.2);
    }

    .ai-fab-ring {
        position: absolute;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid rgba(167,139,250,0.5);
        animation: fab-pulse 2s ease-out infinite;
        pointer-events: none;
    }

    .ai-fab-ring-2 {
        animation-delay: 1s;
        border-color: rgba(99,102,241,0.35);
    }

    @keyframes fab-pulse {
        0%   { transform: scale(1);   opacity: 0.8; }
        100% { transform: scale(1.9); opacity: 0; }
    }

    .ai-fab-icon {
        flex-shrink: 0;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        position: relative;
        z-index: 1;
        animation: fab-bob 3s ease-in-out infinite;
    }

    @keyframes fab-bob {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-3px); }
    }

    .ai-fab-label {
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        white-space: nowrap;
        opacity: 0;
        max-width: 0;
        overflow: hidden;
        letter-spacing: 0.2px;
        transition: opacity 0.25s 0.1s, max-width 0.35s;
        position: relative;
        z-index: 1;
    }

    .ai-fab:hover .ai-fab-label {
        opacity: 1;
        max-width: 120px;
    }

    .ai-fab:active {
        transform: scale(0.94);
        transition: transform 0.1s;
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
    .swal2-popup { font-family: 'Inter', sans-serif !important; border-radius: 16px !important; }
    .swal2-title { font-size: 1.15rem !important; font-weight: 700 !important; }
    .swal2-html-container { font-size: 0.9rem !important; }
    .swal2-confirm { border-radius: 10px !important; font-weight: 600 !important; font-size: 0.88rem !important; padding: 0.55rem 1.2rem !important; }
    .swal2-cancel { border-radius: 10px !important; font-weight: 600 !important; font-size: 0.88rem !important; padding: 0.55rem 1.2rem !important; }
    .swal2-toast { border-radius: 12px !important; font-family: 'Inter', sans-serif !important; }
</style>
</body>
</html>
