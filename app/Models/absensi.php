<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class absensi extends Model
{
    protected $table = 'absensi';

    protected $guarded = ['id'];

    public function mahasiswaBaru(): BelongsTo
    {
        return $this->belongsTo(MahasiswaBaru::class, 'mahasiswa_baru_id');
    }

    public function jadwalKegiatan(): BelongsTo
    {
        return $this->belongsTo(JadwalKegiatan::class, 'jadwal_kegiatan_id');
    }
}