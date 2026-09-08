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
    Schema::create('predictions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('alumni_id')->constrained('alumnis')->onDelete('cascade');
        $table->string('hasil_prediksi'); 
        $table->decimal('probabilitas', 5, 2); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
