<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataMahasiswa extends Model
{
    protected $table = 'data_mahasiswa';

    protected $guarded = ['id'];

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }
}