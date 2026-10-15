<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'mapel_id',
        'ortu_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status',
        'qr_data',
        'keterangan',
        'lokasi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
    ];

    /**
     * Get the siswa that made the presensi
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get the guru that verified the presensi
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Get the mapel (subject) for the presensi
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    /**
     * Get the ortu (parent) that made the presensi
     */
    public function ortu()
    {
        return $this->belongsTo(Ortu::class);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        $statusMap = [
            'hadir' => 'status--hadir',
            'izin' => 'status--izin',
            'sakit' => 'status--izin',
            'alpha' => 'status--alpha',
            'terlambat' => 'status--izin',
        ];

        return $statusMap[$this->status] ?? 'status--alpha';
    }

    /**
     * Format waktu masuk
     */
    public function getWaktuMasukFormattedAttribute()
    {
        if (!$this->waktu_masuk) {
            return '-';
        }

        if ($this->waktu_masuk instanceof Carbon) {
            return $this->waktu_masuk->format('H:i');
        }

        return Carbon::parse($this->waktu_masuk)->format('H:i');
    }
}

