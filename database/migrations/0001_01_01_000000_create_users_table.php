<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('phone')->nullable();;
            $table->enum('offering', ['A', 'B', 'C', 'D'])->nullable();
       
            $table->enum('role', ['siswa', 'guru', 'admin'])->default('siswa');
            
            $table->enum('school_name', [
                'SMKN 4 MALANG',
                'SMKN 5 MALANG',
                'SMKN 6 MALANG',
                'SMKN 8 MALANG',
                'SMKN 9 MALANG',
                'SMKN 11 MALANG',
                'SMKN 12 MALANG',
                'SMPN 8 MALANG',
            ])->nullable();
            
            $table->integer('level')->default(1);
            $table->integer('exp')->default(0);
            $table->string('mood', 20)->default('😊')->nullable();

            $table->string('grade')->nullable(); 
            $table->enum('major_or_subject', [
                'Rekayasa Perangkat Lunak',
                'Teknik Jaringan Komputer dan Telekomunikasi',
                'Teknik Jaringan dan Telekomunikasi'
            ])->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
