<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_posting_id',
        'name',
        'email',
        'phone',
        'domicile',
        'profesi',
        'profesi_lainnya',
        'instansi',
        'education_level',
        'position_experience',
        'impactful_project',
        'cv_file',
        'portfolio_file',
        'status',
    ];

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel job_postings
     */
    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class, 'job_posting_id');
    }

    /**
     * Log aplikasi (jika ada fitur tracking atau histori)
     */
    public function logs()
    {
        return $this->hasMany(ApplicationLog::class);
    }
}