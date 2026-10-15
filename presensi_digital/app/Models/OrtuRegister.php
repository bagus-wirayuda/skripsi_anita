<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrtuRegister extends Model
{
    use HasFactory;

    protected $table = 'orturegister';

    protected $fillable = [
        'name',
        'email',
        'nik',
        'hubungan',
        'pekerjaan',
        'pendidikan',
        'no_hp',
        'alamat',
    ];
}
