<?php

namespace App\Models;

use App\Models\Kelompok;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataMahasiswa extends Model
{
    use HasFactory;

     protected $table = "data_mahasiswa";

    protected $fillable = [
        'nim',
        'nama',
        'kelompok_id',

    ];
// izinKehadiran

    public function izinKehadiran()
    {
        return $this->hasMany(IzinKehadiran::class, 'nim', 'nim');
    }
public function izins()
{
    return $this->hasMany(IzinKehadiran::class, 'nim', 'nim');
}

// barangSitaan

    public function barangSitaan()
    {
        return $this->belongsTo(BarangSitaan::class);
    }

//   kelompok
public function kelompok()
{
    return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
}
// absensis
public function absensis()
{
    return $this->hasMany(Absensi::class, 'data_mahasiswa_id', 'id');
}

public function absensi()
{
    return $this->hasMany(Absensi::class, 'mahasiswa_id');
}

}
