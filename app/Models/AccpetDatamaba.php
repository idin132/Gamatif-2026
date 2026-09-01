<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccpetDatamaba extends Model
{
    protected $table = "mahasiswa_baru";
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nim',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'nomor_whatsapp',
        'email',
        'bukti_sosmed',
        'bukti_registrasi',
        'kelompok_id',
        'password',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'bukti_sosmed' => 'array',
        'tanggal_lahir' => 'date',
    ];
       public function kelompok()
    {
        return $this->belongsTo(\App\Models\Kelompok::class, 'kelompok_id');
    }
}
