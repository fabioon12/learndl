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
        Schema::table('tahapan_users', function (Blueprint $table) {
            if (!Schema::hasColumn('tahapan_users', 'exp_didapat')) {
                $table->unsignedInteger('exp_didapat')
                    ->default(0);
            }

            if (!Schema::hasColumn('tahapan_users', 'jawaban')) {
                $table->json('jawaban')->nullable();
            }

            if (!Schema::hasColumn('tahapan_users', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tahapan_users', function (Blueprint $table) {
            $columns = ['exp_didapat', 'jawaban', 'completed_at'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('tahapan_users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
