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
        Schema::create('soal_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruang_ujian_id')
                ->constrained('ruang_ujians')
                ->cascadeOnDelete();
            $table->unsignedInteger('urutan')->default(1);
            $table->longText('pertanyaan');
            $table->string('tipe')->default('pilihan_ganda');
            $table->json('opsi')->nullable();
            $table->string('jawaban_benar');
            $table->unsignedInteger('exp')->default(10);
            $table->text('pembahasan')->nullable();
            $table->timestamps();
            $table->index(['ruang_ujian_id', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_ujians');
    }
};
