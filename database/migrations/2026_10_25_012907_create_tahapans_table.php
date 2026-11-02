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
        Schema::create('tahapans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruang_belajar_id')->constrained('ruang_belajars')->onDelete('cascade');
            $table->foreignId('ruang_materi_id')->nullable()->constrained('materis')->onDelete('set null');
            $table->string('judul_tahapan');
            $table->enum('tipe', [
                'apersepsi', 
                'ice_breaking', 
                'pre_test', 
                'materi', 
                'lkpd', 
                'evaluasi', 
                'kesimpulan', 
                'refleksi', 
                'post_test', 
                'tindak_lanjut'
            ])->default('materi'); 
            $table->integer('urutan')->default(1); 
            $table->enum('status', ['selesai', 'aktif', 'terkunci'])->default('terkunci');
            $table->string('icon')->default('fa-code'); 
            $table->json('konten')->nullable();
            $table->integer('xp_reward')->default(100); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahapans');
    }
};
