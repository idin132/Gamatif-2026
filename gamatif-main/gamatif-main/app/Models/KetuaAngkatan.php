<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetuaAngkatan extends Model
{
    use HasFactory;
    
    protected $table = 'ketua_angkatan';

    protected $fillable = [
        'nim',
        'nama',
        'kelas',
        'foto',
        'visi',
        'misi',
    ];
}
