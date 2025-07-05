<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelamarProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'phone',
        'gender',
        'birth_place',
        'birth_date',
        'id_number',
        'address',
        'education_level',
        'summary',
        'work_experience',
        'achievements',
        'certifications',
        'skills',
        'languages',
        'interests',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}