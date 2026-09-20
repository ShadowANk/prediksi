<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Tracer Study') - Tracer WICIDA</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            letter-spacing: -0.01em;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            padding: 0.5rem 0;
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.88rem;
            padding: 0.4rem 1rem !important;
            border-radius: 50px;
            transition: 0.2s;
            color: #475569 !important;
        }

        .nav-link:hover {
            color: var(--primary) !important;
            background-color: #f1f5f9;
        }

        .nav-link.active {
            background: var(--primary);
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
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
            .navbar {
                padding: 0.75rem 0;
            }

            .navbar-collapse {
                background: #ffffff;
                border-radius: 16px;
                padding: 1rem;
                margin-top: 0.5rem;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
                border: 1px solid #f1f5f9;
            }

            .navbar-nav {
                padding-top: 0.25rem;
                gap: 0.5rem !important;
            }

            .nav-link {
                border-radius: 10px;
                padding: 0.6rem 1rem !important;
            }

            .nav-link.active {
                box-shadow: none;
            }

            .card {
                border-radius: 16px;
            }

            .card-body {
                padding: 1.25rem !important;
            }

            .chart-container {
                height: 250px !important;
            }

            .metric-value {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 575.98px) {
            body {
                font-size: 0.9rem;
            }

            h2 {
                font-size: 1.4rem;
            }

            .btn {
                font-size: 0.85rem;
            }

            .table {
                font-size: 0.85rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light sticky-top mb-4">
    <div class="container">

        <a
            class="navbar-brand d-flex align-items-center"
            href="{{ route('dashboard') }}"
        >
            <img src="{{ asset('images/logo-bkk.png') }}" alt="BKK WICIDA Logo" style="height: 42px; width: auto;">
        </a>

        <button
            class="navbar-toggler border-0"
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
            <ul class="navbar-nav ms-auto gap-lg-1 align-items-lg-center">

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
                    <i class="bi bi-people me-1"></i>
                        Data Alumni
                    </a>
                </li>

                <li class="nav-item ms-lg-2">
                    <a
                        class="btn btn-outline-success btn-sm rounded-pill px-3 py-1 mt-1 mt-lg-0 fw-semibold"
                        href="{{ route('sync.google') }}"
                        title="Sinkronkan data dari Google Sheet"
                    >
                        <i class="bi bi-cloud-arrow-down-fill me-1"></i>
                        Sync Sheet
                    </a>
                </li>

                @auth
                <li class="nav-item ms-lg-2">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1 mt-1 mt-lg-0 fw-semibold">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>
                @endauth

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