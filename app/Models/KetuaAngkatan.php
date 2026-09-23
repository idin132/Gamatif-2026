<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetuaAngkatan extends Model
{
    protected $table = 'ketua_angkatan';

    protected $guarded = ['id'];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    public function votes()
    {
        return $this->hasMany(KetuaAngkatanVote::class, 'ketua_angkatan_id');
    }
}