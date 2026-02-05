<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Koridor extends Model
{
    use HasFactory;

    protected $table = 'master_koridors';

    protected $fillable = [
        'nama_koridor',
    ];

    // Relasi: 1 Koridor punya banyak Aduan
    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'koridor_id');
    }
}
