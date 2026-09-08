<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Tracer Study') - Tracer WICIDA</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
            --dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #334155;
        }

        .navbar {
            background-color: rgba(15, 23, 42, 0.96);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
        }

        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1.2rem !important;
            border-radius: 50px;
            transition: 0.2s;
            color: rgba(255, 255, 255, 0.72) !important;
        }

        .nav-link:hover {
            color: #fff !important;
        }

        .nav-link.active {
            background: var(--primary);
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem;
            font-weight: 700;
        }

        .btn-pill {
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }

        .badge-pill {
            border-radius: 50px;
            padding: 6px 12px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .table thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.04em;
            color: #64748b;
            padding: 1rem;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .metric-value {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .section-title {
            color: #0f172a;
            font-weight: 700;
        }

        main {
            min-height: calc(100vh - 120px);
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                padding-top: 1rem;
            }

            .nav-link {
                border-radius: 12px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top mb-4">
    <div class="container">

        <a
            class="navbar-brand fw-bold fs-4"
            href="{{ route('dashboard') }}"
        >
            <i class="bi bi-mortarboard-fill text-primary me-2"></i>
            Tracer <span class="text-primary">WICIDA</span>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div
            class="collapse navbar-collapse"
            id="navbarNav"
        >
            <ul class="navbar-nav ms-auto gap-lg-2">

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}"
                    >
                        <i class="bi bi-grid-fill me-1"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('evaluasi.*') ? 'active' : '' }}"
                        href="{{ route('evaluasi.index') }}"
                    >
                        <i class="bi bi-clipboard-data-fill me-1"></i>
                        Evaluasi Model
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('alumni.*') ? 'active' : '' }}"
                        href="{{ route('alumni.index') }}"
                    >
                    <i class="bi bi-people"></i>
                        Data Alumni
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>

<main class="container pb-5">

    {{-- Flash Success --}}
    @if(session('success'))
        <div
            class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4"
            role="alert"
        >
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif

    {{-- Flash Error --}}
    @if(session('error'))
        <div
            class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4"
            role="alert"
        >
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif

    {{-- Validation Error --}}
    @if($errors->any())
        <div
            class="alert alert-danger border-0 shadow-sm rounded-4"
            role="alert"
        >
            <div class="fw-bold mb-2">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                Data belum dapat diproses
            </div>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</main>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>

@stack('scripts')

</body>
</html>