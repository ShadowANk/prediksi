<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Support\Facades\Http;

class GoogleSheetController extends Controller
{
    private $sheetUrl = "https://docs.google.com/spreadsheets/d/e/2PACX-1vQo1kjbhNa0JCeID6QYqPJ_4fOUTBFrPemIX0X2LTLjh8MjlyTF8FYEcvEaV7WQYBT5UtSfPs9VGUl2/pub?output=csv";

    /*
    |--------------------------------------------------------------------------
    | TAMPIL DATA GOOGLE SHEET
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data = $this->getGoogleData();

        return view(
            'alumni.google',
            compact('data')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SYNC GOOGLE SHEET KE DATABASE
    |--------------------------------------------------------------------------
    */
    public function sync()
    {
        $rows = $this->getGoogleData();
        $now = now();
        $insertData = [];

        foreach ($rows as $row) {
            if (empty($row['nama_lengkap'])) {
                continue;
            }

            $nim = !empty($row['nim']) ? $row['nim'] : 'AUTO-' . uniqid();

            $insertData[] = [
                'nim'           => $nim,
                'nama_lengkap'  => $row['nama_lengkap'] ?? 'Tidak Ada Nama',
                'email_address' => $row['email_address'] ?? null,
                'no_whatsapp'   => $row['no_whatsapp'] ?? null,
                'program_studi' => $this->formatProdiName($row['kode_prodi'] ?? null),
                'tahun_lulus'   => $row['tahun_lulus'] ?? null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        if (!empty($insertData)) {
            // Processing in chunks of 100 using bulk upsert
            foreach (array_chunk($insertData, 100) as $chunk) {
                Alumni::upsert(
                    $chunk,
                    ['nim'], // Unique key to update on match
                    ['nama_lengkap', 'email_address', 'no_whatsapp', 'program_studi', 'tahun_lulus', 'updated_at']
                );
            }
        }

        return redirect()->back()
            ->with(
                'success',
                'Data alumni berhasil disinkronkan dari Google Sheet!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA GOOGLE SHEET
    |--------------------------------------------------------------------------
    */
    private function getGoogleData(): array
    {
        $csv = Http::get($this->sheetUrl)->body();

        $rows = array_map(
            function ($line) {
                return str_getcsv($line, ",", '"');
            },
            explode("\n", $csv)
        );

        $data = [];

        foreach ($rows as $row) {
            if (empty(array_filter($row))) {
                continue;
            }

            $tahun = $row[3] ?? null;
            $email = $row[1] ?? null;

            if (
                !is_numeric($tahun)
                || empty($email)
                || !str_contains($email, '@')
            ) {
                continue;
            }

            $data[] = [
                'email_address' => trim($email),
                'nama_lengkap'  => trim($row[2] ?? ''),
                'tahun_lulus'   => intval($tahun),
                'nim'           => trim($row[4] ?? ''),
                'kode_prodi'    => trim($row[5] ?? ''),
                'no_whatsapp'   => trim($row[6] ?? ''),
            ];
        }

        return $data;
    }

    private function formatProdiName(?string $kode): string
    {
        if (!$kode) {
            return 'Lainnya';
        }
        $kodeUpper = strtoupper(trim($kode));
        if (str_contains($kodeUpper, 'TI') || str_contains($kodeUpper, '552')) {
            return 'Teknik Informatika';
        }
        if (str_contains($kodeUpper, 'SI') || str_contains($kodeUpper, '572')) {
            return 'Sistem Informasi';
        }
        if (str_contains($kodeUpper, 'MI') || str_contains($kodeUpper, '574')) {
            return 'Manajemen Informatika';
        }
        return trim($kode);
    }
}