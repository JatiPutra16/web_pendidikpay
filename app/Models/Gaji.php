<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = "gaji";
    protected $primaryKey = 'idgaji';

    protected $dates = ['tgl_gaji'];

    protected $casts = [
        'tgl_gaji' => 'datetime',
    ];

    protected $fillable = ['idabsen', 'total_jam', 'total_gaji', 'gaji_bersih', 'tgl_gaji'];

    // Hubungan dengan model Absen
    public function absen()
    {
        return $this->belongsTo(Absen::class, 'idabsen', 'idabsen');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'idguru', 'idguru');
    }
}
