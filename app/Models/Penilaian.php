<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = ['nama_wisata', 'deskripsi', 'kategori', 'latitude', 'longitude'];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}
