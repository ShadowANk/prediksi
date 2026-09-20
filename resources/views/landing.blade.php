<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - Tracer Study WICIDA</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary-text: #475569;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            letter-spacing: -0.01em;
            overflow-x: hidden;
        }

        .hero-section {
            position: relative;
            padding: 130px 0 90px;
            background: linear-gradient(180deg, #eef2ff 0%, #f8fafc 100%);
        }

        .light-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .light-card:hover {
            transform: translateY(-5px);
            border-color: rgba(79, 70, 229, 0.4);
            box-shadow: 0 20px 35px -10px rgba(79, 70, 229, 0.15);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.45);
            color: white;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e1b4b;
        }

        .badge-pill {
            background: #e0e7ff;
            color: #4338ca;
            border: 1px solid #c7d2fe;
            border-radius: 50px;
            padding: 6px 18px;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo-bkk.png') }}" alt="BKK WICIDA Logo" style="height: 48px; width: auto;">
            </a>
            
            <div class="ms-auto d-flex align-items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-gradient btn-sm px-4">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gradient btn-sm px-4">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Admin
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span class="badge-pill mb-3 d-inline-block">
                        <i class="bi bi-cpu-fill me-1"></i> Sistem Prediksi Operasional Alumni ML
                    </span>
                    
                    <h1 class="display-4 fw-extrabold text-dark mb-4">
                        Sistem Pelacakan & Prediksi Karir Alumni STMIK WICIDA
                    </h1>
                    
                    <p class="lead text-secondary mb-5 px-lg-4">
                        Platform cerdas penelusuran alumni berbasis machine learning untuk memantau status pekerjaan, evaluasi kurikulum, dan memprediksi penyerapan karir lulusan secara akurat.
                    </p>

                    <div class="d-flex justify-content-center gap-3 mb-5">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-gradient btn-lg">
                                Buka Dashboard System <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-gradient btn-lg">
                                Masuk ke Sistem <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- STATS COUNTER -->
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="light-card p-4">
                        <i class="bi bi-people-fill text-primary fs-1 mb-2"></i>
                        <div class="stat-number">790+</div>
                        <div class="text-secondary fw-semibold">Total Data Alumni</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="light-card p-4">
                        <i class="bi bi-cpu-fill text-success fs-1 mb-2"></i>
                        <div class="stat-number">88.5%</div>
                        <div class="text-secondary fw-semibold">Akurasi Model ML</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="light-card p-4">
                        <i class="bi bi-cloud-arrow-down-fill text-info fs-1 mb-2"></i>
                        <div class="stat-number">Realtime</div>
                        <div class="text-secondary fw-semibold">Sync Google Sheets</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark mb-2">Fitur Unggulan Platform</h2>
                <p class="text-secondary">Teknologi mutakhir untuk pengelolaan data tracer study</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="light-card p-4 h-100">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-4 d-inline-block mb-3">
                            <i class="bi bi-graph-up-arrow text-primary fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Dashboard Visualisasi</h5>
                        <p class="text-secondary small">Monitoring distribusi alumni per program studi dan grafik perbandingan aktual vs hasil prediksi operasional.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="light-card p-4 h-100">
                        <div class="bg-success bg-opacity-10 p-3 rounded-4 d-inline-block mb-3">
                            <i class="bi bi-robot text-success fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Machine Learning Model</h5>
                        <p class="text-secondary small">Integrasi model prediksi berbasis file Joblib untuk memprediksi potensi penyerapan alumni ke dunia kerja.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="light-card p-4 h-100">
                        <div class="bg-info bg-opacity-10 p-3 rounded-4 d-inline-block mb-3">
                            <i class="bi bi-file-earmark-spreadsheet text-info fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Sinkronisasi Instan</h5>
                        <p class="text-secondary small">Integrasi data otomatis langsung dari kuesioner Google Sheets dengan sekali klik tanpa ribet.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-4 border-top border-slate-200 text-center text-secondary small bg-light">
        <div class="container">
            &copy; {{ date('Y') }} Tracer Study STMIK WICIDA. All rights reserved.
        </div>
    </footer>

</body>
</html>
