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
        Schema::create('user_tahapan_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID Siswa
            $table->foreignId('tahapan_id')->constrained('tahapans')->onDelete('cascade');
            $table->enum('status', ['selesai', 'aktif', 'terkunci'])->default('terkunci');
            $table->timestamps();
            $table->unique(['user_id', 'tahapan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tahapan_progress');
    }
};
