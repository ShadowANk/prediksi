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
                'nim' => '20.41.001',
                'nama_lengkap' => 'Rian Hidayat',
                'email_address' => 'rian.hidayat@example.com',
                'no_whatsapp' => '081234567890',
                'program_studi' => 'Teknik Informatika',
                'tahun_lulus' => 2024,
                'feature' => [
                    'f3_mencari_kerja_sebelum_lulus' => 1,
                    'f6_jumlah_lamaran' => 5,
                    'f17a_kompetensi_it' => 4.0,
                    'f17a_kompetensi_inggris' => 3.5,
                    'f17a_kompetensi_komunikasi' => 4.0,
                    'f17a_kompetensi_kerjasama' => 4.5,
                ],
                'tracer' => [
                    'f8_status' => 'Bekerja',
                    'f5b_nama_perusahaan' => 'PT Teknologi Jaya',
                    'pendapatan_per_bulan' => 5000000,
                    'f14_hubungan_studi' => 'Erat',
                ]
            ],
            [
                'nim' => '20.41.002',
                'nama_lengkap' => 'Siti Aminah',
                'email_address' => 'siti.aminah@example.com',
                'no_whatsapp' => '082345678901',
                'program_studi' => 'Sistem Informasi',
                'tahun_lulus' => 2024,
                'feature' => [
                    'f3_mencari_kerja_sebelum_lulus' => 0,
                    'f6_jumlah_lamaran' => 2,
                    'f17a_kompetensi_it' => 3.5,
                    'f17a_kompetensi_inggris' => 4.0,
                    'f17a_kompetensi_komunikasi' => 4.0,
                    'f17a_kompetensi_kerjasama' => 4.0,
                ],
                'tracer' => [
                    'f8_status' => 'Melanjutkan Pendidikan',
                    'f5b_nama_perusahaan' => null,
                    'pendapatan_per_bulan' => null,
                    'f14_hubungan_studi' => null,
                ]
            ],
            [
                'nim' => '20.41.003',
                'nama_lengkap' => 'Budi Santoso',
                'email_address' => 'budi.santoso@example.com',
                'no_whatsapp' => '083456789012',
                'program_studi' => 'Manajemen Informatika',
                'tahun_lulus' => 2024,
                'feature' => [
                    'f3_mencari_kerja_sebelum_lulus' => 0,
                    'f6_jumlah_lamaran' => 3,
                    'f17a_kompetensi_it' => 4.0,
                    'f17a_kompetensi_inggris' => 3.0,
                    'f17a_kompetensi_komunikasi' => 3.5,
                    'f17a_kompetensi_kerjasama' => 4.0,
                ],
                'tracer' => [
                    'f8_status' => 'Belum Bekerja / Mencari Kerja',
                    'f5b_nama_perusahaan' => null,
                    'pendapatan_per_bulan' => null,
                    'f14_hubungan_studi' => null,
                ]
            ],
        ];

        foreach ($dataAlumni as $item) {
            $alumni = Alumni::updateOrCreate(
                ['nim' => $item['nim']],
                [
                    'nama_lengkap' => $item['nama_lengkap'],
                    'email_address' => $item['email_address'],
                    'no_whatsapp' => $item['no_whatsapp'],
                    'program_studi' => $item['program_studi'],
                    'tahun_lulus' => $item['tahun_lulus'],
                ]
            );

            AlumniFeature::updateOrCreate(
                ['alumni_id' => $alumni->id],
                [
                    'f3_mencari_kerja_sebelum_lulus' => $item['feature']['f3_mencari_kerja_sebelum_lulus'],
                    'f6_jumlah_lamaran' => $item['feature']['f6_jumlah_lamaran'],
                    'f17a_kompetensi_it' => $item['feature']['f17a_kompetensi_it'],
                    'f17a_kompetensi_inggris' => $item['feature']['f17a_kompetensi_inggris'],
                    'f17a_kompetensi_komunikasi' => $item['feature']['f17a_kompetensi_komunikasi'],
                    'f17a_kompetensi_kerjasama' => $item['feature']['f17a_kompetensi_kerjasama'],
                ]
            );

            TracerStudy::updateOrCreate(
                ['alumni_id' => $alumni->id],
                [
                    'f8_status' => $item['tracer']['f8_status'],
                    'f5b_nama_perusahaan' => $item['tracer']['f5b_nama_perusahaan'],
                    'pendapatan_per_bulan' => $item['tracer']['pendapatan_per_bulan'],
                    'f14_hubungan_studi' => $item['tracer']['f14_hubungan_studi'],
                ]
            );
        }
    }
}