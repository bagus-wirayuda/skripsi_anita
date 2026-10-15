<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import related models for relationships
use App\Models\PenilaianHarian;
use App\Models\Nilai;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'kelas_id',
        'ortu_id',
        'nama_siswa',
        'nis',
        'nisn',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'alamat',
        'qr_code',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the kelas that the siswa belongs to
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Get the ortu that owns the siswa (ortu_id)
     */
    public function ortu()
    {
        return $this->belongsTo(Ortu::class, 'ortu_id');
    }

    /**
     * Get the presensi records for the siswa
     */
    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    /**
     * Get the penilaian harian records for the siswa
     */
    public function penilaianHarian()
    {
        return $this->hasMany(PenilaianHarian::class);
    }

    /**
     * Get the nilai records for the siswa
     */
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    /**
     * Get jenis kelamin in full form
     */
    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        // Status bisa di-set berdasarkan logika bisnis
        // Untuk sementara, kita anggap semua aktif
        return 'status--hadir';
    }
}

