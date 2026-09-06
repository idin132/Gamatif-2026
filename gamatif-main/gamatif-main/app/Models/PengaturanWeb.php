<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanWeb extends Model
{
    use HasFactory;
    
    protected $table = "pengaturan_web";

    protected $fillable = [
        'logo_unikom',
        'logo_hmif',
        'logo_kabinet',
        'logo_gamatif',
        'logo_maskot',
        'admin_wa_1',
        'admin_wa_2',
        'buku_saku',
        'email',
        'nama_kegiatan',

    ];
}
