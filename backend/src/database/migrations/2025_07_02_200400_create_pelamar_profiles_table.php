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
        $table->string('first_name')->nullable(); 
        $table->string('last_name')->nullable();  
        $table->string('profile_picture')->nullable(); 
        $table->string('phone')->nullable(); 
        $table->enum('gender', ['laki-laki', 'perempuan'])->nullable(); 
        $table->string('birth_place')->nullable(); 
        $table->date('birth_date')->nullable(); 
        $table->string('id_number')->nullable(); 
        $table->text('address')->nullable(); 
        $table->enum('education_level', ['SMA/sederajat', 'D3', 'S1', 'S2', 'S3'])->nullable();
        $table->string('major')->nullable(); 
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
