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
        Schema::table('jawaban_ujians', function (Blueprint $table) {
            $table->decimal('skor_esai', 8, 2)->nullable();
            $table->text('catatan_guru')->nullable();
            $table->timestamp('dinilai_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_ujians', function (Blueprint $table) {
            $table->dropColumn([
                'skor_esai',
                'catatan_guru',
                'dinilai_pada',
            ]);
        });
    }
};
