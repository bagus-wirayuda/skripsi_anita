<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianHarian extends Model
{
    use HasFactory;

    protected $table = 'penilaian_harian';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'tanggal',
        'jenis_penilaian',
        'nilai',
        'deskripsi',
        'catatan_guru',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nilai' => 'decimal:2',
    ];

    /**
     * Get the siswa that was assessed
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get the mapel (subject) for the assessment
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    /**
     * Get nilai as stars (1-5)
     */
    public function getStarsAttribute()
    {
        if (!$this->nilai) {
            return 0;
        }

        // Convert 0-100 to 1-5 stars
        if ($this->nilai >= 90) {
            return 5;
        } elseif ($this->nilai >= 80) {
            return 4;
        } elseif ($this->nilai >= 70) {
            return 3;
        } elseif ($this->nilai >= 60) {
            return 2;
        } else {
            return 1;
        }
    }
}







