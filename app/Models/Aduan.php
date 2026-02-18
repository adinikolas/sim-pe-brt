<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aduan extends Model
{
    use HasFactory;

    protected $table = 'aduans';

    protected $fillable = [
        'tanggal',
        'jam',
        'pelapor',
        'pta',
        'pengemudi',
        'no_armada',
        'tkp',
        'koridor_id',
        'jenis_aduan_id',
        'media_pelaporan',
        'isi_aduan',
        'status',
        'keterangan_tindak_lanjut',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke Koridor
    public function koridor()
    {
        return $this->belongsTo(Koridor::class, 'koridor_id');
    }

    // Relasi ke Jenis Aduan
    public function jenisAduan()
    {
        return $this->belongsTo(JenisAduan::class, 'jenis_aduan_id');
    }

    // Relasi ke Lampiran Aduan
    public function lampirans()
    {
        return $this->hasMany(AduanLampiran::class);
    }
}

