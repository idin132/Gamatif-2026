<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangSitaan extends Model
{
    use HasFactory;

    
    protected $table = "barang_sitaan";

    protected $fillable = [
        'tanggal',
        'kelompok_id',
        'barang_sitaan',
        'foto',
    ];

    public function dataMahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'nim', 'nim');
    }

    public function kelompok()
{
    return $this->belongsTo(Kelompok::class, 'kelompok_id');
}
public function mahasiswa()
{
    return $this->belongsTo(DataMahasiswa::class, 'mahasiswa_id');
}
}
