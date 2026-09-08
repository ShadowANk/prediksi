@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php
    $totalPredicted = ($predTerserap ?? 0) + ($predBelum ?? 0);

    $coverage = $totalAlumni > 0
        ? ($totalPredicted / $totalAlumni) * 100
        : 0;
@endphp


{{-- HEADER --}}
<div class="d-flex align-items-center mb-4">

    <div class="bg-primary text-white p-3 rounded-4 me-3 shadow-sm">
        <i class="bi bi-graph-up-arrow fs-3"></i>
    </div>

    <div>
        <h2 class="fw-bold mb-0">
            Dashboard Monitoring Alumni
        </h2>

        <p class="text-muted mb-0">
            Data aktual tracer study dan hasil prediksi operasional.
        </p>
    </div>

</div>


{{-- KPI --}}
<div class="row g-4 mb-4">

    @php
        $stats = [
            [
                'Total Alumni',
                $totalAlumni,
                'bi-people-fill',
                'primary'
            ],
            [
                'Terserap Aktual',
                $totalTerserapAsli,
                'bi-briefcase-fill',
                'success'
            ],
            [
                'Tidak Terserap Aktual',
                $totalBelumAsli,
                'bi-search',
                'warning'
            ],
            [
                'Sudah Diprediksi',
                $totalPredicted,
                'bi-cpu-fill',
                'info'
            ]
        ];
    @endphp


    @foreach($stats as $stat)

        <div class="col-sm-6 col-xl-3">

            <div class="card p-4 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="text-secondary fw-bold small text-uppercase mb-1">
                            {{ $stat[0] }}
                        </h6>

                        <h2 class="fw-bold mb-0 text-dark">
                            {{ number_format($stat[1]) }}
                        </h2>

                    </div>

                    <div class="bg-{{ $stat[3] }}-subtle p-3 rounded-circle">

                        <i
                            class="bi {{ $stat[2] }}
                            fs-3 text-{{ $stat[3] }}"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>


{{-- COVERAGE --}}
<div class="card mb-4">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-2">

            <div>

                <h6 class="fw-bold mb-1">
                    Cakupan Prediksi Operasional
                </h6>

                <small class="text-muted">
                    Alumni yang sudah mempunyai hasil prediksi.
                </small>

            </div>

            <strong>
                {{ number_format($coverage, 1) }}%
            </strong>

        </div>

        <div class="progress" style="height: 10px;">

            <div
                class="progress-bar bg-primary"
                style="width: {{ min(100, $coverage) }}%"
            ></div>

        </div>

    </div>

</div>


@if($totalPredicted < $totalAlumni)

    <div class="alert alert-warning border-0 rounded-4 shadow-sm">

        <i class="bi bi-exclamation-triangle-fill me-2"></i>

        Prediksi operasional baru tersedia untuk

        <strong>{{ $totalPredicted }}</strong>

        dari

        <strong>{{ $totalAlumni }}</strong>

        alumni.

        Grafik aktual dan prediksi memiliki jumlah observasi yang berbeda
        sampai seluruh alumni selesai diprediksi.

    </div>

@endif


<div class="row g-4 mb-4">

    {{-- DISTRIBUSI STATUS --}}
    <div class="col-lg-6">

        <div class="card p-4 h-100">

            <div class="mb-4">

                <h6 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-pie-chart-fill me-2 text-primary"></i>
                    Status Aktual Alumni
                </h6>

                <small class="text-muted">
                    Berdasarkan hasil tracer study.
                </small>

            </div>

            <div style="height: 300px;">
                <canvas id="statusChart"></canvas>
            </div>

        </div>

    </div>


    {{-- PERBANDINGAN OPERASIONAL --}}
    <div class="col-lg-6">

        <div class="card p-4 h-100">

            <div class="mb-4">

                <h6 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-bar-chart-fill me-2 text-success"></i>
                    Aktual vs Prediksi Operasional
                </h6>

                <small class="text-muted">
                    Perbandingan distribusi kelas.
                    Bukan confusion matrix atau evaluasi model.
                </small>

            </div>

            <div style="height: 300px;">
                <canvas id="comparisonChart"></canvas>
            </div>

        </div>

    </div>


    {{-- PROGRAM STUDI --}}
    <div class="col-12">

        <div class="card p-4">

            <div class="mb-4">

                <h6 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-mortarboard-fill me-2 text-warning"></i>
                    Distribusi Alumni per Program Studi
                </h6>

                <small class="text-muted">
                    Jumlah data alumni berdasarkan program studi.
                </small>

            </div>

            <div style="height: 350px;">
                <canvas id="prodiChart"></canvas>
            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>


<script>

    Chart.register(ChartDataLabels);

    Chart.defaults.font.family =
        "'Plus Jakarta Sans', sans-serif";

    Chart.defaults.color = '#64748b';


    const dataLabelConfig = {
        anchor: 'end',
        align: 'top',

        color: '#334155',

        font: {
            weight: 'bold',
            size: 12
        },

        formatter: function(value) {
            return value;
        }
    };


    /*
    |--------------------------------------------------------------------------
    | Status Aktual
    |--------------------------------------------------------------------------
    */

    new Chart(
        document.getElementById('statusChart'),
        {
            type: 'doughnut',

            data: {

                labels: @json(
                    $tracerStatus
                        ->pluck('f8_status')
                        ->values()
                ),

                datasets: [{
                    data: @json(
                        $tracerStatus
                            ->pluck('total')
                            ->values()
                    ),

                    backgroundColor: [
                        '#4f46e5',
                        '#10b981',
                        '#f59e0b',
                        '#06b6d4',
                        '#ef4444'
                    ],

                    borderWidth: 0,

                    hoverOffset: 15
                }]
            },

            options: {

                maintainAspectRatio: false,

                cutout: '65%',

                plugins: {

                    legend: {
                        position: 'bottom',

                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },

                    datalabels: {
                        color: '#ffffff',

                        font: {
                            weight: 'bold',
                            size: 13
                        },

                        formatter: function(value) {
                            return value > 0
                                ? value
                                : '';
                        }
                    }
                }
            }
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Actual vs Operational Prediction
    |--------------------------------------------------------------------------
    */

    new Chart(
        document.getElementById('comparisonChart'),
        {
            type: 'bar',

            data: {

                labels: [
                    'Terserap',
                    'Tidak Terserap'
                ],

                datasets: [

                    {
                        label: 'Data Aktual',

                        data: [
                            {{ $actualTerserap }},
                            {{ $actualBelum }}
                        ],

                        backgroundColor: '#10b981',

                        borderRadius: 8
                    },

                    {
                        label: 'Prediksi Operasional',

                        data: [
                            {{ $predTerserap }},
                            {{ $predBelum }}
                        ],

                        backgroundColor: '#4f46e5',

                        borderRadius: 8
                    }

                ]
            },

            options: {

                maintainAspectRatio: false,

                layout: {
                    padding: {
                        top: 30
                    }
                },

                plugins: {

                    legend: {
                        position: 'bottom',

                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },

                    datalabels: dataLabelConfig
                },

                scales: {

                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: '#f1f5f9'
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }

                }
            }
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Program Studi
    |--------------------------------------------------------------------------
    */

    new Chart(
        document.getElementById('prodiChart'),
        {
            type: 'bar',

            data: {

                labels: @json(
                    $prodiDistribution
                        ->pluck('program_studi')
                        ->values()
                ),

                datasets: [{
                    label: 'Total Alumni',

                    data: @json(
                        $prodiDistribution
                            ->pluck('total')
                            ->values()
                    ),

                    backgroundColor: '#f59e0b',

                    borderRadius: 10,

                    maxBarThickness: 55
                }]
            },

            options: {

                maintainAspectRatio: false,

                layout: {
                    padding: {
                        top: 30
                    }
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    datalabels: dataLabelConfig
                },

                scales: {

                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: '#f1f5f9'
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }

                }
            }
        }
    );

</script>

@endpush