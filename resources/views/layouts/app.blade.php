<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SplitMoney</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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

    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
