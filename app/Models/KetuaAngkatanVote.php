<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KetuaAngkatanVote extends Model
{
    protected $table = 'ketua_angkatan_votes';

    protected $guarded = ['id'];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(MahasiswaBaru::class, 'mahasiswa_baru_id');
    }

    public function kandidat(): BelongsTo
    {
        return $this->belongsTo(KetuaAngkatan::class, 'ketua_angkatan_id');
    }
}
