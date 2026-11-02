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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('cascade'); 
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['kuis', 'pre-test', 'post-test', 'latihan'])->default('kuis');
            $table->json('target_schools')->nullable();
            $table->enum('status', ['draft', 'terbit', 'ditutup'])->default('terbit');
            $table->integer('durasi_menit')->default(60);
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
