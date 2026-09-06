<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangBawaan extends MahasiswaBaru
{
    use HasFactory;
     protected $table = "barang_bawaan";
    protected $fillable = [
     'absensi_id',
    'jadwal_kegiatan_id',
          'Nama_Barang_Bawaan_id'
    ];
public function absensi()
{
    return $this->belongsTo(Absensi::class, 'absensi_id');
}

public function namaBarang()
{
    return $this->belongsTo(NamaBarangBawaan::class, 'Nama_Barang_Bawaan_id');
}

  public function jadwalKegiatan()
    {
        return $this->belongsTo(JadwalKegiatan::class, 'jadwal_kegiatan_id');
    }
 public function namaBarangBawaan()
    {
        return $this->belongsTo(NamaBarangBawaan::class, 'Nama_Barang_Bawaan_id');
    }
}
