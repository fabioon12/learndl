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
        Schema::create('hasil_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruang_ujian_id')
                ->constrained('ruang_ujians')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('tahapan_id')
                ->nullable()
                ->constrained('tahapans')
                ->nullOnDelete();

            $table->unsignedInteger('total_soal')->default(0);
            $table->unsignedInteger('jumlah_benar')->default(0);
            $table->unsignedInteger('jumlah_salah')->default(0);

            $table->decimal('nilai', 5, 2)->default(0);

            // Total EXP yang benar-benar diperoleh siswa
            $table->unsignedInteger('exp_diperoleh')->default(0);

            $table->enum('status', [
                'berlangsung',
                'selesai',
            ])->default('berlangsung');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'ruang_ujian_id']);
            $table->index(['user_id', 'tahapan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujians');
    }
};
