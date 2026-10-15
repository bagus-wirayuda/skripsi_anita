<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Import related models for relationships
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Ortu;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
        // 'password' => 'hashed', // DISABLED FOR DEVELOPMENT
    ];

    /**
     * Get the siswa profile for this user (for academic data only, not for login)
     * Note: Siswa is not a login role, this is only for data relationship
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    /**
     * Get the guru profile for this user (if role is guru)
     */
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    /**
     * Get the ortu profile for this user (if role is orangtua)
     */
    public function ortu()
    {
        return $this->hasOne(Ortu::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is guru
     */
    public function isGuru()
    {
        return $this->role === 'guru';
    }

    /**
     * Check if user is orangtua (ortu)
     */
    public function isOrtu()
    {
        return $this->role === 'ortu';
    }

    /**
     * Check if user is kepala sekolah (kepsek)
     */
    public function isKepsek()
    {
        return $this->role === 'kepsek';
    }
}
