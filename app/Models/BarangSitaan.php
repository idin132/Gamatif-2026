<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangSitaan extends Model
{
    protected $table = 'barang_sitaan';

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }
}