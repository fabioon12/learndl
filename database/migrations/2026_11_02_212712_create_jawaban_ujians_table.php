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
        Schema::create('jawaban_ujians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hasil_ujian_id')
                ->constrained('hasil_ujians')
                ->cascadeOnDelete();

            $table->foreignId('soal_ujian_id')
                ->constrained('soal_ujians')
                ->cascadeOnDelete();

            // Jawaban yang dipilih siswa, misalnya A atau B
            $table->text('jawaban_siswa')->nullable();

            $table->boolean('benar')->default(false);

            // EXP untuk soal ini
            $table->unsignedInteger('exp_diperoleh')->default(0);

            $table->timestamps();

            $table->unique(
                ['hasil_ujian_id', 'soal_ujian_id'],
                'hasil_soal_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_ujians');
    }
};
