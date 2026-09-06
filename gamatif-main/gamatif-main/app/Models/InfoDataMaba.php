<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kelompok;

class InfoDataMaba extends Model
{
    protected $table = 'mahasiswa_baru';
    use HasFactory;

public function kelompok()
{
    return $this->belongsTo(Kelompok::class, 'kelompok_id');
}


}
