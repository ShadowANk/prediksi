<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\TracerStudy;
use App\Models\Prediction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Ringkasan (Cards)
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

        // 4. Data Grafik 3: Perbandingan Status Asli vs Hasil Prediksi (Hanya Alumni yang Punya Hasil Prediksi)
        $actualTerserap = TracerStudy::whereHas('alumni.prediction')
            ->whereIn('f8_status', ['Bekerja', 'Wirausaha', 'Melanjutkan Pendidikan'])
            ->count();
        $actualBelum = TracerStudy::whereHas('alumni.prediction')
            ->where('f8_status', 'Belum Bekerja / Mencari Kerja')
            ->count();
        
        $predTerserap = Prediction::where('hasil_prediksi', 'Terserap')->count();
        $predBelum = Prediction::where('hasil_prediksi', 'Belum Terserap')->count();

        return view('dashboard', compact(
            'totalAlumni', 'totalTerserapAsli', 'totalBelumAsli',
            'tracerStatus', 'prodiDistribution', 'actualTerserap', 'actualBelum',
            'predTerserap', 'predBelum'
        ));
    }
}
