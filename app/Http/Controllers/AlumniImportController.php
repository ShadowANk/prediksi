<?php

namespace App\Http\Controllers;
    
use App\Models\Alumni;
use App\Models\TracerStudy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;
use App\Models\Prediction;


class AlumniImportController extends Controller
{
    public function evaluasiModel()
{
    $evaluation = $this->getModelEvaluation();

    return view(
        'evaluasi.index',
        compact('evaluation')
    );
}
    public function showDashboard()
{
    // 1. Statistik Ringkasan (Cards) - Bersih dari Gaji
    $totalAlumni = Alumni::count();
    $totalTerserapAsli = TracerStudy::whereIn('f8_status', ['Bekerja', 'Wirausaha', 'Melanjutkan Pendidikan'])->count();
    $totalBelumAsli = TracerStudy::where('f8_status', 'Belum Bekerja / Mencari Kerja')->count();

    // 2. Data Grafik 1: Status Penyerapan Alumni (Tracer Study)
    $tracerStatus = DB::table('tracer_studies')
        ->select('f8_status', DB::raw('count(*) as total'))
        ->groupBy('f8_status')
        ->get();

    // 3. Data Grafik 2: Distribusi Alumni per Program Studi
    $prodiDistribution = DB::table('alumnis')
        ->select('program_studi', DB::raw('count(*) as total'))
        ->groupBy('program_studi')
        ->get();

    // 4. Data Grafik 3: Perbandingan Status Asli vs Hasil Prediksi
    $actualTerserap = TracerStudy::whereIn('f8_status', ['Bekerja', 'Wirausaha', 'Melanjutkan Pendidikan'])->count();
    $actualBelum = TracerStudy::where('f8_status', 'Belum Bekerja / Mencari Kerja')->count();
    
    $predTerserap = Prediction::where('hasil_prediksi', 'Terserap')->count();
    $predBelum = Prediction::where('hasil_prediksi', 'Belum Terserap')->count();

    return view('dashboard', compact(
        'totalAlumni', 'totalTerserapAsli', 'totalBelumAsli',
        'tracerStatus', 'prodiDistribution', 'actualTerserap', 'actualBelum',
        'predTerserap', 'predBelum'
    ));
}

    public function predict($alumniId)
{
    $alumni = Alumni::with('feature')
        ->findOrFail($alumniId);

    $feature = $alumni->feature;

    if (!$feature) {
        return redirect()
            ->back()
            ->with(
                'error',
                'Data fitur alumni belum tersedia.'
            );
    }

    $payload = [
        'mencari_kerja'
            => $feature
                ->f3_mencari_kerja_sebelum_lulus
                ? 1
                : 0,

        'jumlah_lamaran'
            => $feature->f6_jumlah_lamaran,

        'comp_it'
            => $feature->f17a_kompetensi_it,

        'comp_inggris'
            => $feature->f17a_kompetensi_inggris,

        'comp_komunikasi'
            => $feature->f17a_kompetensi_komunikasi,

        'comp_kerjasama'
            => $feature->f17a_kompetensi_kerjasama,
    ];

    $tempJsonPath = tempnam(
        storage_path('app'),
        'predict_'
    );

    file_put_contents(
        $tempJsonPath,
        json_encode(
            $payload,
            JSON_UNESCAPED_UNICODE
        )
    );

    $pythonPath = config('ml.python_bin');

    try {

        $result = Process::path(
            base_path('ml-api')
        )
            ->timeout(60)
            ->run([
                $pythonPath,
                'predict.py',
                $tempJsonPath
            ]);

        if (!$result->successful()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Python gagal: ' .
                    $result->errorOutput()
                );
        }

        $output = json_decode(
            trim($result->output()),
            true
        );

        if (
            !is_array($output) ||
            ($output['status'] ?? null) !== 'success'
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Prediksi gagal: ' .
                    ($output['message']
                        ?? 'Output Python tidak valid.')
                );
        }

        Prediction::updateOrCreate(
            [
                'alumni_id' => $alumni->id
            ],
            [
                'hasil_prediksi'
                    => $output['prediction'],

                'probabilitas'
                    => $output['confidence'],
            ]
        );

        return redirect()
            ->back()
            ->with(
                'success',
                'Prediksi berhasil. Hasil: ' .
                $output['prediction'] .
                ' (' .
                $output['confidence'] .
                '%)'
            );

    } finally {

        if (
            $tempJsonPath &&
            file_exists($tempJsonPath)
        ) {
            unlink($tempJsonPath);
        }
    }
}
public function predictAll()
{
    $alumnis = Alumni::with('feature')->get();

    if ($alumnis->isEmpty()) {
        return redirect()
            ->back()
            ->with(
                'error',
                'Data alumni belum tersedia.'
            );
    }

    $payload = [];

    foreach ($alumnis as $alumni) {

        $feature = $alumni->feature;

        if (!$feature) {
            continue;
        }

        $payload[] = [
            'alumni_id' => $alumni->id,

            'mencari_kerja'
                => $feature
                    ->f3_mencari_kerja_sebelum_lulus
                    ? 1
                    : 0,

            'jumlah_lamaran'
                => $feature->f6_jumlah_lamaran,

            'comp_it'
                => $feature->f17a_kompetensi_it,

            'comp_inggris'
                => $feature->f17a_kompetensi_inggris,

            'comp_komunikasi'
                => $feature->f17a_kompetensi_komunikasi,

            'comp_kerjasama'
                => $feature->f17a_kompetensi_kerjasama,
        ];
    }

    if (empty($payload)) {
        return redirect()
            ->back()
            ->with(
                'error',
                'Tidak ada data fitur yang dapat diprediksi.'
            );
    }

    $tempJsonPath = tempnam(
        storage_path('app'),
        'predict_batch_'
    );

    file_put_contents(
        $tempJsonPath,
        json_encode(
            $payload,
            JSON_UNESCAPED_UNICODE
        )
    );

    $pythonPath = config('ml.python_bin');

    try {

        $result = Process::path(
            base_path('ml-api')
        )
            ->timeout(180)
            ->run([
                $pythonPath,
                'predict_batch.py',
                $tempJsonPath
            ]);

        if (!$result->successful()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Python gagal: ' .
                    $result->errorOutput()
                );
        }

        $output = json_decode(
            trim($result->output()),
            true
        );

        if (
            !is_array($output) ||
            ($output['status'] ?? null) !== 'success'
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Prediksi massal gagal: ' .
                    ($output['message']
                        ?? 'Output tidak valid.')
                );
        }

        DB::transaction(function () use ($output) {

            foreach ($output['data'] as $row) {

                Prediction::updateOrCreate(
                    [
                        'alumni_id'
                            => $row['alumni_id']
                    ],
                    [
                        'hasil_prediksi'
                            => $row['prediction'],

                        'probabilitas'
                            => $row['confidence']
                    ]
                );
            }
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'Prediksi berhasil dilakukan untuk ' .
                count($output['data']) .
                ' alumni.'
            );

    } finally {

        if (
            $tempJsonPath &&
            file_exists($tempJsonPath)
        ) {
            unlink($tempJsonPath);
        }
    }
}

    private function getModelEvaluation(): array
{
    $metadataPath = base_path(
        'ml-api' .
        DIRECTORY_SEPARATOR .
        'model_metadata.json'
    );

    $default = [
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
    ];

    if (!file_exists($metadataPath)) {
        return $default;
    }

    $metadata = json_decode(
        file_get_contents($metadataPath),
        true
    );

    if (!is_array($metadata)) {
        return $default;
    }

    $hasil = $metadata[
        'hasil_data_uji_persen'
    ] ?? [];

    return [
        'total_predicted'
            => (
                ($hasil['tp'] ?? 0) +
                ($hasil['tn'] ?? 0) +
                ($hasil['fp'] ?? 0) +
                ($hasil['fn'] ?? 0)
            ),

        'accuracy'
            => $hasil['test_accuracy'] ?? 0,

        'balanced_accuracy'
            => $hasil['balanced_accuracy'] ?? 0,

        'precision'
            => $hasil['precision_terserap'] ?? 0,

        'recall'
            => $hasil['recall_terserap'] ?? 0,

        'f1_score'
            => $hasil['f1_terserap'] ?? 0,

        'train_accuracy'
            => $hasil['train_accuracy'] ?? 0,

        'train_test_gap'
            => $hasil['train_test_gap'] ?? 0,

        'tp' => $hasil['tp'] ?? 0,
        'tn' => $hasil['tn'] ?? 0,
        'fp' => $hasil['fp'] ?? 0,
        'fn' => $hasil['fn'] ?? 0,
    ];
}
}