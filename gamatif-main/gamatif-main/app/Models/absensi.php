<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'mahasiswa_baru_id',
        'jadwal_kegiatan_id',
        'status',
    ];


    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaBaru::class, 'mahasiswa_baru_id');
    }
    //change commit
    public function jadwal()
    {
        return $this->belongsTo(JadwalKegiatan::class, 'jadwal_kegiatan_id');
    }

    public function mahasiswaBaru()
    {
        return $this->belongsTo(MahasiswaBaru::class, 'mahasiswa_baru_id');
    }

    public function jadwalKegiatan()
    {
        return $this->belongsTo(JadwalKegiatan::class, 'jadwal_kegiatan_id');
    }


public function barangBawaans()
{
    return $this->hasMany(BarangBawaan::class, 'absensi_id');
}



}