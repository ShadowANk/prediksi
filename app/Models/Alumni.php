<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    // Tambahkan nim, email_address, no_whatsapp, dan program_studi di sini
    protected $fillable = [
        'nim',
        'nama_lengkap',
        'email_address',
        'no_whatsapp',
        'program_studi',
        'tahun_lulus'
    ];

    public function tracerStudy()
    {
        return $this->hasOne(TracerStudy::class);
    }

    public function feature()
    {
        return $this->hasOne(AlumniFeature::class);
    }

    public function prediction()
    {
        return $this->hasOne(Prediction::class);
    }
}