<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumni;
use App\Models\AlumniFeature;
use App\Models\TracerStudy;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $dataAlumni = [
            [
                'nisn' => '0012345678',
                'nama_lengkap' => 'Rian Hidayat',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'tahun_lulus' => 2025,
                'feature' => [
                    'nilai_rata_rata' => 88.50,
                    'nilai_pkl' => 90.00,
                    'memiliki_sertifikasi' => true,
                    'aktif_organisasi' => true,
                ],
                'tracer' => [
                    'status' => 'Bekerja',
                    'nama_instansi' => 'PT Teknologi Jaya',
                    'pendapatan' => 5000000,
                ]
            ],
            [
                'nisn' => '0023456789',
                'nama_lengkap' => 'Siti Aminah',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'tahun_lulus' => 2025,
                'feature' => [
                    'nilai_rata_rata' => 85.00,
                    'nilai_pkl' => 82.50,
                    'memiliki_sertifikasi' => false,
                    'aktif_organisasi' => true,
                ],
                'tracer' => [
                    'status' => 'Kuliah',
                    'nama_instansi' => 'Universitas Indonesia',
                    'pendapatan' => null,
                ]
            ],
            [
                'nisn' => '0034567890',
                'nama_lengkap' => 'Budi Santoso',
                'jurusan' => 'Teknik Komputer Jaringan',
                'tahun_lulus' => 2025,
                'feature' => [
                    'nilai_rata_rata' => 78.00,
                    'nilai_pkl' => 80.00,
                    'memiliki_sertifikasi' => true,
                    'aktif_organisasi' => false,
                ],
                'tracer' => [
                    'status' => 'Bekerja',
                    'nama_instansi' => 'Cyber Sentosa',
                    'pendapatan' => 4500000,
                ]
            ],
            [
                'nisn' => '0045678901',
                'nama_lengkap' => 'Dewi Lestari',
                'jurusan' => 'Teknik Komputer Jaringan',
                'tahun_lulus' => 2025,
                'feature' => [
                    'nilai_rata_rata' => 72.50,
                    'nilai_pkl' => 75.00,
                    'memiliki_sertifikasi' => false,
                    'aktif_organisasi' => false,
                ],
                'tracer' => [
                    'status' => 'Belum Bekerja',
                    'nama_instansi' => null,
                    'pendapatan' => null,
                ]
            ],
            [
                'nisn' => '0056789012',
                'nama_lengkap' => 'Fajar Pratama',
                'jurusan' => 'Multi Media',
                'tahun_lulus' => 2025,
                'feature' => [
                    'nilai_rata_rata' => 81.20,
                    'nilai_pkl' => 85.00,
                    'memiliki_sertifikasi' => false,
                    'aktif_organisasi' => false,
                ],
                'tracer' => [
                    'status' => 'Wirausaha',
                    'nama_instansi' => 'Fajar Studio Kreatif',
                    'pendapatan' => 3500000,
                ]
            ],
        ];

        foreach ($dataAlumni as $item) {
            $alumni = Alumni::create([
                'nisn' => $item['nisn'],
                'nama_lengkap' => $item['nama_lengkap'],
                'jurusan' => $item['jurusan'],
                'tahun_lulus' => $item['tahun_lulus'],
            ]);

            AlumniFeature::create([
                'alumni_id' => $alumni->id,
                'nilai_rata_rata' => $item['feature']['nilai_rata_rata'],
                'nilai_pkl' => $item['feature']['nilai_pkl'],
                'memiliki_sertifikasi' => $item['feature']['memiliki_sertifikasi'],
                'aktif_organisasi' => $item['feature']['aktif_organisasi'],
            ]);

            TracerStudy::create([
                'alumni_id' => $alumni->id,
                'status' => $item['tracer']['status'],
                'nama_instansi' => $item['tracer']['nama_instansi'],
                'pendapatan' => $item['tracer']['pendapatan'],
            ]);
        }
    }
}