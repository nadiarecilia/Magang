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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_posting_id')->constrained('job_postings')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('domicile')->nullable();
            $table->string('profesi')->nullable();           
            $table->string('profesi_lainnya')->nullable();    
            $table->string('instansi')->nullable(); 
            $table->string('education_level')->nullable();
            $table->enum('position_experience', ['<1 tahun', '1-2 tahun', '3-5 tahun', '>5 tahun'])->nullable();
            $table->text('impactful_project')->nullable();
            $table->string('cv_file')->nullable();
            $table->string('portfolio_file')->nullable();
            $table->enum('status', [
                'Lamaran Dikirim', 
                'Lamaran Direview', 
                'Interview', 
                'Diterima', 
                'Ditolak'
            ])->default('Lamaran Dikirim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
