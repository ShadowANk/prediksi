<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('alumni_features', function (Blueprint $table) {
        $table->id();
        $table->foreignId('alumni_id')->constrained('alumnis')->onDelete('cascade');
        // f3: Kapan mulai mencari pekerjaan (1 = Sebelum Lulus, 0 = Setelah Lulus)
        $table->boolean('f3_mencari_kerja_sebelum_lulus')->default(false);
        // f6: Berapa instansi yang dilamar
        $table->integer('f6_jumlah_lamaran')->default(0);
        // F17a: Rata-rata nilai kompetensi saat lulus (skala 1-5 dari kuesioner)
        $table->decimal('f17a_kompetensi_it', 3, 2); // Penggunaan teknologi informasi
        $table->decimal('f17a_kompetensi_inggris', 3, 2); // Bahasa Inggris
        $table->decimal('f17a_kompetensi_komunikasi', 3, 2); // Komunikasi
        $table->decimal('f17a_kompetensi_kerjasama', 3, 2); // Kerjasama tim
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_features');
    }
};
