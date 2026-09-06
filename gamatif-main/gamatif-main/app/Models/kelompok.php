<?php

namespace App\Models;

use App\Models\DataMahasiswa;
use App\Models\IzinKehadiran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelompok extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kelompok',
        'url_grub'
    ];

    public function dataMahasiswa()
    {
        return $this->hasMany(DataMahasiswa::class, 'kelompok_id');
        // 'kelompok' = FK di data_mahasiswa
    }
    // app/Models/Kelompok.php
    // public function mahasiswas()
    // {
    //     return $this->hasMany(DataMahasiswa::class, 'kelompok_id','kelompok', 'id');
    // }
    public function mahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'id');
    }

    public function mahasiswaBaru()
    {
        return $this->hasMany(MahasiswaBaru::class, 'kelompok_id');
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }
    public function IzinKehadiran()
    {
        return $this->hasMany(IzinKehadiran::class);
    }
    
    public function dataMaba()
    {
        return $this->hasMany(InfoDataMaba::class, 'kelompok_id');
    }
}
