<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar_url',
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the avatar URL for Filament user interface.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url
            ? asset('storage/' . $this->avatar_url)
            : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?d=mp&r=g&s=250';
    }

    /**
     * Allow access to Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    // =======================
    // Relasi
    // =======================
    public function pelamarProfile()
    {
        return $this->hasOne(PelamarProfile::class);
    }

    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class, 'rekruter_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function applicationLogs()
    {
        return $this->hasMany(ApplicationLog::class);
    }
}