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
        Schema::create('ruang_ujians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('judul');
            $table->text('deskripsi')->nullable();

            $table->unsignedInteger('durasi_menit')->default(30);
            $table->unsignedInteger('maksimal_percobaan')->default(1);

            $table->boolean('acak_soal')->default(false);
            $table->boolean('acak_jawaban')->default(false);

            $table->enum('status', [
                'draft',
                'aktif',
                'nonaktif',
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruang_ujians');
    }
};
