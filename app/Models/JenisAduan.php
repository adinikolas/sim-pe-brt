<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisAduan extends Model
{
    use HasFactory;

    protected $table = 'master_jenis_aduans';

    protected $fillable = [
        'nama_aduan',
    ];

    // Relasi: 1 Jenis Aduan punya banyak Aduan
    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'jenis_aduan_id');
    }
}
