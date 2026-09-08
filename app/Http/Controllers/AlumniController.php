<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nim', 'like', '%' . $search . '%');
            });
        }


        // Filter Program Studi
        if ($request->filled('program_studi')) {
            $query->where(
                'program_studi',
                $request->program_studi
            );
        }


        // Filter Tahun Lulus
        if ($request->filled('tahun_lulus')) {
            $query->where(
                'tahun_lulus',
                $request->tahun_lulus
            );
        }


        $alumnis = $query
            ->orderBy('tahun_lulus','desc')
            ->paginate(10)
            ->withQueryString();


        $programStudis = Alumni::select('program_studi')
            ->distinct()
            ->orderBy('program_studi')
            ->pluck('program_studi');


        $tahunLulus = Alumni::select('tahun_lulus')
            ->distinct()
            ->orderBy('tahun_lulus','desc')
            ->pluck('tahun_lulus');


        return view(
            'alumni.index',
            compact(
                'alumnis',
                'programStudis',
                'tahunLulus'
            )
        );
    }
}