<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Tracer Study WICIDA</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #eef2ff 0%, #f1f5f9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            letter-spacing: -0.01em;
        }

        .login-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            box-shadow: 0 20px 40px -15px rgba(79, 70, 229, 0.12);
            width: 100%;
            max-width: 440px;
            padding: 40px;
        }

        .form-control {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: var(--primary);
            color: #1e293b;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .btn-login {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.45);
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="text-center mb-4">
            <div class="mb-3">
                <img src="{{ asset('images/logo-bkk.png') }}" alt="BKK WICIDA Logo" style="height: 80px; width: auto;">
            </div>
            <h4 class="fw-bold text-dark mb-1">Selamat Datang</h4>
            <p class="text-secondary small">Masuk ke Sistem Tracer WICIDA</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-3 p-3 mb-4 small" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3 p-3 mb-4 small" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label text-secondary small fw-semibold">Email Administrator</label>
                <div class="input-group">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="admin@wicida.ac.id" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-secondary small fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input border-slate-300" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-secondary small" for="remember">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                Masuk Sistem <i class="bi bi-box-arrow-in-right ms-1"></i>
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('landing') }}" class="text-secondary text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Landing Page
            </a>
        </div>
    </div>

</body>
</html>
