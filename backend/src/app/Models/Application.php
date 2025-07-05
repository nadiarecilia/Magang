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
        'education_level',
        'position_experience',
        'impactful_project',
        'cv_file',
        'portfolio_file',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function logs()
    {
        return $this->hasMany(ApplicationLog::class);
    }
}