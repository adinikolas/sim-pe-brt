<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanLampiran extends Model
{
    protected $fillable = ['aduan_id', 'file_path'];

    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }
}
