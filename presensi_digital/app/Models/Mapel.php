<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import related models for relationships
use App\Models\PenilaianHarian;
use App\Models\Nilai;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'nama_mapel',
        'kode_mapel',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'jam_per_minggu',
        'deskripsi',
    ];

    /**
     * Get the guru that teaches this mapel
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Get the kelas that this mapel is taught in
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Get the presensi records for this mapel
     */
    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    /**
     * Get the penilaian harian records for this mapel
     */
    public function penilaianHarian()
    {
        return $this->hasMany(PenilaianHarian::class);
    }

    /**
     * Get the nilai records for this mapel
     */
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}

