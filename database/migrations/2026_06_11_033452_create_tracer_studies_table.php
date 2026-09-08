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
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumnis')->onDelete('cascade');
            // f8: Status alumni saat ini
            $table->enum('f8_status', ['Bekerja', 'Wirausaha', 'Melanjutkan Pendidikan', 'Belum Bekerja / Mencari Kerja']);
            $table->string('f5b_nama_perusahaan')->nullable();
            $table->integer('pendapatan_per_bulan')->nullable();
            // f14: Hubungan bidang studi (Sangat Erat, Erat, Cukup Erat, Kurang Erat, Tidak Erat)
            $table->string('f14_hubungan_studi')->nullable(); 
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_studies');
    }
};
