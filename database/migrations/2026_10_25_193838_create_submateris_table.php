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
        Schema::create('submateris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_id')
                  ->constrained('materis')
                  ->onDelete('cascade');
            $table->string('judul_sub');
            $table->text('deskripsi')->nullable();
            $table->json('tipe');
            $table->string('estimasi_waktu')->default('10 menit');
            $table->enum('status', ['terbit', 'draft'])->default('terbit');
            $table->integer('xp_reward')->default(25); 
            $table->json('konten_builder')->nullable();
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submateris');
    }
};
