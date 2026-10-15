<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'urutan_kelas',
        'rombel',
        'wali_kelas',
        'wali_kelas_id',
        'deskripsi',
        'catatan',
        'kapasitas',
    ];

    /**
     * Get the siswa (students) in this kelas
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    /**
     * Get the mapel (subjects) for this kelas
     */
    public function mapel()
    {
        return $this->hasMany(Mapel::class);
    }

    /**
     * Get the wali kelas (homeroom teacher) for this kelas
     */
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }
}

