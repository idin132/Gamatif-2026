<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class kelompok extends Model
{
    protected $table = 'kelompoks';

    protected $guarded = ['id'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'kelompok_id');
    }

    public function mahasiswaBarus(): HasMany
    {
        return $this->hasMany(MahasiswaBaru::class, 'kelompok_id');
    }

    public function dataMahasiswas(): HasMany
    {
        return $this->hasMany(DataMahasiswa::class, 'kelompok_id');
    }

    public function barangSitaans(): HasMany
    {
        return $this->hasMany(BarangSitaan::class, 'kelompok_id');
    }
}