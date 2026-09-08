<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'f3_mencari_kerja_sebelum_lulus',
        'f6_jumlah_lamaran',
        'f17a_kompetensi_it',
        'f17a_kompetensi_inggris',
        'f17a_kompetensi_komunikasi',
        'f17a_kompetensi_kerjasama'
    ];

    protected $casts = [
        'f3_mencari_kerja_sebelum_lulus' => 'boolean',
        'f6_jumlah_lamaran' => 'integer',
        'f17a_kompetensi_it' => 'float',
        'f17a_kompetensi_inggris' => 'float',
        'f17a_kompetensi_komunikasi' => 'float',
        'f17a_kompetensi_kerjasama' => 'float',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}