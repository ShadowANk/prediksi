@extends('layouts.app')

@section('title', 'Evaluasi Model')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Nilai bawaan
    |--------------------------------------------------------------------------
    | Data pada halaman ini hanya berasal dari model_metadata.json.
    */
    $evaluation = array_merge([
        'total_predicted' => 0,
        'accuracy' => 0,
        'balanced_accuracy' => 0,
        'precision' => 0,
        'recall' => 0,
        'f1_score' => 0,
        'train_accuracy' => 0,
        'train_test_gap' => 0,
        'tp' => 0,
        'tn' => 0,
        'fp' => 0,
        'fn' => 0,
    ], $evaluation ?? []);

    $testTotal =
        (int) $evaluation['tp']
        + (int) $evaluation['tn']
        + (int) $evaluation['fp']
        + (int) $evaluation['fn'];

    $gapAbsolute = abs((float) $evaluation['train_test_gap']);
@endphp

{{-- JUDUL HALAMAN --}}
<div class="mb-4">
    <h2 class="fw-bold mb-1 text-dark">
        Evaluasi Model Random Forest
    </h2>

    <p class="text-muted mb-0">
        Menampilkan hasil pengujian model pada independent hold-out test set.
    </p>
</div>

{{-- KARTU METRIK --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-activity text-primary me-2"></i>
        Metrik Kinerja Model
    </div>

    <div class="card-body p-4">
        <div class="row g-4">

            <div class="col-md-6 col-xl">
                <div class="p-3 bg-light rounded-4 h-100">
                    <small class="text-muted fw-semibold">Accuracy</small>
                    <div class="metric-value text-primary mt-1">
                        {{ number_format((float) $evaluation['accuracy'], 2) }}%
                    </div>
                    <small class="text-muted">
                        Ketepatan klasifikasi secara keseluruhan.
                    </small>
                </div>
            </div>

            <div class="col-md-6 col-xl">
                <div class="p-3 bg-light rounded-4 h-100">
                    <small class="text-muted fw-semibold">Balanced Accuracy</small>
                    <div class="metric-value text-dark mt-1">
                        {{ number_format((float) $evaluation['balanced_accuracy'], 2) }}%
                    </div>
                    <small class="text-muted">
                        Rata-rata recall pada kedua kelas.
                    </small>
                </div>
            </div>

            <div class="col-md-6 col-xl">
                <div class="p-3 bg-light rounded-4 h-100">
                    <small class="text-muted fw-semibold">Precision</small>
                    <div class="metric-value text-success mt-1">
                        {{ number_format((float) $evaluation['precision'], 2) }}%
                    </div>
                    <small class="text-muted">
                        Precision untuk kelas Terserap.
                    </small>
                </div>
            </div>

            <div class="col-md-6 col-xl">
                <div class="p-3 bg-light rounded-4 h-100">
                    <small class="text-muted fw-semibold">Recall</small>
                    <div class="metric-value text-warning mt-1">
                        {{ number_format((float) $evaluation['recall'], 2) }}%
                    </div>
                    <small class="text-muted">
                        Recall untuk kelas Terserap.
                    </small>
                </div>
            </div>

            <div class="col-md-6 col-xl">
                <div class="p-3 bg-light rounded-4 h-100">
                    <small class="text-muted fw-semibold">F1-Score</small>
                    <div class="metric-value text-info mt-1">
                        {{ number_format((float) $evaluation['f1_score'], 2) }}%
                    </div>
                    <small class="text-muted">
                        Rata-rata harmonik precision dan recall.
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="row g-4">

    {{-- CONFUSION MATRIX --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-grid-3x3-gap-fill text-success me-2"></i>
                    Confusion Matrix
                </span>

                <span class="badge bg-primary-subtle text-primary rounded-pill">
                    Test Set: {{ $testTotal }} data
                </span>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle mb-3">
                        <thead>
                            <tr>
                                <th rowspan="2" colspan="2"></th>
                                <th colspan="2">Prediksi</th>
                            </tr>
                            <tr>
                                <th>Terserap</th>
                                <th>Tidak Terserap</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th rowspan="2" class="align-middle bg-light">Aktual</th>
                                <th class="bg-light">Terserap</th>

                                <td class="bg-success bg-opacity-10">
                                    <div class="fw-bold text-success fs-4">
                                        {{ (int) $evaluation['tp'] }}
                                    </div>
                                    <small>True Positive</small>
                                </td>

                                <td class="bg-danger bg-opacity-10">
                                    <div class="fw-bold text-danger fs-4">
                                        {{ (int) $evaluation['fn'] }}
                                    </div>
                                    <small>False Negative</small>
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-light">Tidak Terserap</th>

                                <td class="bg-danger bg-opacity-10">
                                    <div class="fw-bold text-danger fs-4">
                                        {{ (int) $evaluation['fp'] }}
                                    </div>
                                    <small>False Positive</small>
                                </td>

                                <td class="bg-success bg-opacity-10">
                                    <div class="fw-bold text-success fs-4">
                                        {{ (int) $evaluation['tn'] }}
                                    </div>
                                    <small>True Negative</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Confusion matrix berasal dari data uji independen,
                    bukan dari prediksi operasional pada database.
                </small>
            </div>
        </div>
    </div>

    {{-- GENERALIZATION CHECK --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-shield-check text-primary me-2"></i>
                Generalization Check
            </div>

            <div class="card-body p-4">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Train Accuracy</span>
                        <strong>
                            {{ number_format((float) $evaluation['train_accuracy'], 2) }}%
                        </strong>
                    </div>

                    <div class="progress" style="height: 9px;">
                        <div
                            class="progress-bar bg-primary"
                            role="progressbar"
                            style="width: {{ min(100, max(0, (float) $evaluation['train_accuracy'])) }}%"
                            aria-valuenow="{{ (float) $evaluation['train_accuracy'] }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                        ></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Test Accuracy</span>
                        <strong>
                            {{ number_format((float) $evaluation['accuracy'], 2) }}%
                        </strong>
                    </div>

                    <div class="progress" style="height: 9px;">
                        <div
                            class="progress-bar bg-success"
                            role="progressbar"
                            style="width: {{ min(100, max(0, (float) $evaluation['accuracy'])) }}%"
                            aria-valuenow="{{ (float) $evaluation['accuracy'] }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                        ></div>
                    </div>
                </div>

                <div class="p-3 rounded-4 bg-light mb-3">
                    <small class="text-muted d-block">Train-Test Gap</small>
                    <div class="fw-bold fs-4 text-dark">
                        {{ number_format((float) $evaluation['train_test_gap'], 2) }}
                    </div>
                    <small class="text-muted">poin persentase</small>
                </div>

                <div class="small text-muted">
                    @if($gapAbsolute <= 5)
                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                        Selisih train dan test relatif kecil sehingga tidak menunjukkan
                        indikasi overfitting yang kuat.
                    @else
                        <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>
                        Selisih train dan test perlu diperiksa lebih lanjut karena cukup besar.
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection