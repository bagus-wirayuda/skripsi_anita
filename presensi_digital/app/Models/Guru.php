<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'nip',
        'pangkat',
        'no_hp',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the user that owns the guru
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the mapel (subjects) that the guru teaches
     */
    public function mapel()
    {
        return $this->hasMany(Mapel::class);
    }

    /**
     * Get the presensi records verified by the guru
     */
    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    /**
     * Get the kelas where this guru is wali kelas (kelas binaan)
     */
    public function kelasBinaan()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    /**
     * Get jenis kelamin in full form
     */
    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}

