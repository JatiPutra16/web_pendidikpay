<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = "guru";
    protected $primaryKey = 'idguru';
    protected $fillable = ['idguru', 'nik', 'namaguru', 'foto', 'alamat', 'tlp', 'gajiperjam'];

    public function gaji()
    {
        return $this->hasMany(Gaji::class, 'idguru', 'idguru');
    }

    public function absen()
    {
        return $this->hasMany(Absen::class, 'idguru', 'idguru');
    }
}
