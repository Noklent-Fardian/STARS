<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function lombas(): BelongsToMany
    {
        return $this->belongsToMany(Lomba::class, 't_keahlian_lombas', 'keahlian_id', 'lomba_id');
    }

    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'keahlian_id');
    }
}