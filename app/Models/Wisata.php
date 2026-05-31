<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Wisata extends Model
{
    protected $fillable = [
        'nama_wisata',
        'deskripsi',
        'kategori',
        'latitude',
        'longitude',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }

    public static function clearCache(): void
    {
        foreach (['all', 'Alam', 'Buatan', 'Budaya'] as $cat) {
            for ($page = 1; $page <= 10; $page++) {
                Cache::forget("destinasi_{$cat}_page_{$page}");
            }
        }
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}
