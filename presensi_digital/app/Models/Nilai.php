<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'kelas_id',
        'semester',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'predikat',
        'keterangan',
    ];

    protected $casts = [
        'nilai_tugas' => 'decimal:2',
        'nilai_uts' => 'decimal:2',
        'nilai_uas' => 'decimal:2',
        'nilai_akhir' => 'decimal:2',
    ];

    /**
     * Get the siswa that owns the nilai
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get the mapel (subject) for the nilai
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    /**
     * Get the kelas for the nilai
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Get predikat badge class
     */
    public function getPredikatBadgeClassAttribute()
    {
        $predikatMap = [
            'A' => 'status--hadir',
            'B' => 'status--hadir',
            'C' => 'status--izin',
            'D' => 'status--alpha',
        ];

        return $predikatMap[$this->predikat] ?? 'status--alpha';
    }
}

