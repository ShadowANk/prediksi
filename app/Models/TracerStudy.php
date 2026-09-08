<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama kolom tracer study yang baru
    protected $fillable = [
        'alumni_id',
        'f8_status',
        'f5b_nama_perusahaan',
        'pendapatan_per_bulan',
        'f14_hubungan_studi'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}