<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keahlian extends Model
{
    use HasFactory;
    protected $table = 'm_keahlians';

    protected $fillable = [
        'keahlian_nama',
        'keahlian_visible',
    ];

    protected $casts = [
        'keahlian_visible' => 'boolean',
    ];

    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'keahlian_id');
    }
}