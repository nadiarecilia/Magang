<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelamarProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'profile_picture',
        'phone',
        'gender',
        'birth_place',
        'birth_date',
        'id_number',
        'address',
        'education_level',
        'major',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}