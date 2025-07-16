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
        Schema::create('pelamar_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('first_name')->nullable(); // Nama Depan
        $table->string('last_name')->nullable();  // Nama Belakang
        $table->string('profile_picture')->nullable(); // Foto Profil
        $table->string('phone')->nullable(); // Nomor Telepon
        $table->enum('gender', ['laki-laki', 'perempuan'])->nullable(); // Jenis Kelamin
        $table->string('birth_place')->nullable(); // Tempat Lahir
        $table->date('birth_date')->nullable(); // Tanggal Lahir
        $table->string('id_number')->nullable(); // Nomor KTP
        $table->text('address')->nullable(); // Alamat
        $table->enum('education_level', ['SMA/sederajat', 'D3', 'S1', 'S2', 'S3'])->nullable(); // Pendidikan Terakhir
        $table->text('summary')->nullable(); // Ringkasan Profesional
        $table->text('work_experience')->nullable(); // Pengalaman Kerja
        $table->text('achievements')->nullable(); // Prestasi
        $table->text('certifications')->nullable(); // Sertifikasi
        $table->text('skills')->nullable(); // Keahlian
        $table->text('languages')->nullable(); // Bahasa
        $table->text('interests')->nullable(); // Minat
        $table->string('major')->nullable(); // Jurusan / Major
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelamar_profiles');
    }
};
