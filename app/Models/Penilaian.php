<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'wisata_id',
        'kriteria_id',
        'nilai',
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
