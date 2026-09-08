<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_features', function (Blueprint $table) {

            $table->integer('f6_jumlah_lamaran')
                ->nullable()
                ->default(null)
                ->change();

            $table->decimal(
                'f17a_kompetensi_it',
                3,
                2
            )->nullable()->change();

            $table->decimal(
                'f17a_kompetensi_inggris',
                3,
                2
            )->nullable()->change();

            $table->decimal(
                'f17a_kompetensi_komunikasi',
                3,
                2
            )->nullable()->change();

            $table->decimal(
                'f17a_kompetensi_kerjasama',
                3,
                2
            )->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('alumni_features', function (Blueprint $table) {
            $table->integer('f6_jumlah_lamaran')
                ->default(0)
                ->nullable(false)
                ->change();
        });
    }
};