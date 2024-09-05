<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $table = "absen";
    protected $primaryKey = 'idabsen';
    protected $dates = ['tanggal'];
    protected $fillable = ['idabsen', 'idguru', 'jumlah_jam', 'jumlah_hari', 'tanggal', 'status_gaji'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'idguru' , 'idguru');
    }

    public function gaji()
    {
        return $this->hasOne(Gaji::class, 'idabsen', 'idabsen');
    }
}
