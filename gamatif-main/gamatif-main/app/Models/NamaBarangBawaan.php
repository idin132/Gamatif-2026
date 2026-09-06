<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaBarangBawaan extends Model
{
    use HasFactory;
     protected $table = 'Nama_Barang_Bawaan';

    protected $fillable = [
        'Nama_Barang'
    ];

    public function jadwalKegiatan()
{
    return $this->belongsTo(JadwalKegiatan::class, 'jadwal_kegiatan_id');
}

}
