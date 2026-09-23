<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'data_mahasiswa';

    protected $fillable = [
        'nim',
        'nama',
        'kelompok_id',
        'day_1',
        'day_2',
        'day_3',
        // Day 1
        'makanan_berat_day_1',
        'roti_kepompong_day_1',
        // Day 2
        'makanan_berat_day_2',
        'roti_kepompong_day_2',
        // Day 3
        'makanan_berat_day_3',
        'roti_kepompong_day_3',
    ];

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }
}