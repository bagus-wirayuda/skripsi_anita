<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ortu extends Model
{
    use HasFactory;

    protected $table = 'ortu';

    protected $fillable = [
        'user_id',
        'nik',
        'hubungan',
        'pekerjaan',
        'pendidikan',
        'no_hp',
        'alamat',
    ];

    /**
     * Get the user that owns the ortu
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the siswa (children) of this ortu
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'ortu_id');
    }

    /**
     * Get the presensi records made by this ortu
     */
    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }
}

