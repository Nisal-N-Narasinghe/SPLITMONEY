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
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        html,
        body {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f4f8 0%, #e0e7ff 50%, #f0f4f8 100%);
            color: #1e293b;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(90deg, #0f172a 0%, #1e293b 40%, #7c3aed 100%);
            box-shadow: 0 4px 24px rgba(124, 58, 237, 0.2), 0 2px 12px rgba(0, 0, 0, 0.15);
            padding: 0.95rem 1rem;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff !important;
            background: linear-gradient(90deg, #fff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .navbar-brand i {
            color: #8b5cf6;
            margin-right: 3px;
            animation: brand-pulse 2s ease-in-out infinite;
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
            color: #cbd5e1;
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.06);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-user i {
            font-size: 1.2rem;
            color: #a78bfa;
        }

        .btn-logout {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(59, 130, 246, 0.15));
            border: 1px solid rgba(124, 58, 237, 0.3);
            color: #cbd5e1;
            border-radius: 20px;
            padding: 0.4rem 1rem;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s cubic-bezier(.4, 0, .2, 1);
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.35), rgba(59, 130, 246, 0.35));
            border-color: rgba(139, 92, 246, 0.6);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.3);
        }

        .btn-logout:active {
            transform: translateY(-1px);
        }

        .main-content {
            max-width: 1020px;
            margin: 2.5rem auto;
            padding: 0 1rem;
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
                    <a href="/admin" class="btn-logout"
                        style="text-decoration:none;background:rgba(251,191,36,0.15);border-color:rgba(251,191,36,0.3);color:#fbbf24;">
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
        <a href="/trip-planner" class="ai-fab" title="Plan Your Next Trip">
            <span class="ai-fab-ring"></span>
            <span class="ai-fab-ring ai-fab-ring-2"></span>
            <span class="ai-fab-icon">
                <i class="bi bi-map"></i>
                <i class="bi bi-geo-alt-fill"></i>
            </span>
            <span class="ai-fab-label">Plan Trip</span>
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
            background: linear-gradient(135deg, #059669 0%, #0891b2 50%, #0d9488 100%);
            background-size: 300% 300%;
            border-radius: 50px;
            padding: 0;
            width: 60px;
            height: 60px;
            overflow: hidden;
            box-shadow: 0 12px 48px rgba(5, 150, 105, 0.5), 0 4px 16px rgba(0, 0, 0, 0.2), inset 0 1px 2px rgba(255, 255, 255, 0.2);
            transition: width 0.35s cubic-bezier(.4, 0, .2, 1), border-radius 0.35s, padding 0.35s, box-shadow 0.3s;
            animation: fab-gradient 5s ease infinite, fab-float 3s ease-in-out infinite;
        }

        @keyframes fab-gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes fab-float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .ai-fab:hover {
            width: 180px;
            border-radius: 50px;
            padding-right: 22px;
            box-shadow: 0 16px 56px rgba(5, 150, 105, 0.6), 0 6px 24px rgba(0, 0, 0, 0.25), inset 0 1px 2px rgba(255, 255, 255, 0.3);
        }

        .ai-fab-ring {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid rgba(5, 150, 105, 0.5);
            animation: fab-pulse 2s ease-out infinite;
            pointer-events: none;
        }

        .ai-fab-ring-2 {
            animation-delay: 1s;
            border-color: rgba(13, 148, 136, 0.35);
        }

        @keyframes fab-pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.9);
                opacity: 0;
            }
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

        .ai-fab-icon i {
            position: absolute;
        }

        .ai-fab-icon i:first-child {
            font-size: 1.3rem;
            opacity: 0.8;
            z-index: 1;
        }

        .ai-fab-icon i:last-child {
            font-size: 1rem;
            top: 4px;
            right: 16px;
            animation: pulse-dot 2s ease-in-out infinite;
            z-index: 2;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.9;
            }
        }

        @keyframes fab-bob {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-3px);
            }
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

        @media (max-width: 640px) {
            .ai-fab {
                bottom: 20px;
                right: 20px;
                width: 52px;
                height: 52px;
                box-shadow: 0 8px 32px rgba(5, 150, 105, 0.4), 0 3px 12px rgba(0, 0, 0, 0.2), inset 0 1px 2px rgba(255, 255, 255, 0.2);
            }

            .ai-fab:hover {
                width: 150px;
                padding-right: 18px;
            }

            .ai-fab-icon {
                width: 52px;
                height: 52px;
                font-size: 1.3rem;
            }

            .ai-fab-ring {
                width: 52px;
                height: 52px;
            }

            .ai-fab-label {
                font-size: 0.8rem;
            }

            .ai-fab:hover .ai-fab-label {
                max-width: 100px;
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
