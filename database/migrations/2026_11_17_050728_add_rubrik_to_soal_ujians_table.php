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
        Schema::table('soal_ujians', function (Blueprint $table) {
            $table->string('jawaban_benar')->nullable()->change();
            $table->longText('jawaban_acuan')->nullable();
            $table->json('rubrik_penilaian')->nullable();
            $table->unsignedInteger('skor_maksimal')->default(100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal_ujians', function (Blueprint $table) {
            $table->dropColumn([
                'jawaban_acuan',
                'rubrik_penilaian',
                'skor_maksimal',
            ]);
        });
    }
};
