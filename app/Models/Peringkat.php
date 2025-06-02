<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peringkat extends Model
{
    use HasFactory;

    protected $table = 'm_peringkats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'peringkat_nama',
        'peringkat_bobot',
        'peringkat_visible',
    ];

    protected $casts = [
        'peringkat_bobot' => 'decimal:2',
        'peringkat_visible' => 'boolean',
    ];

    public function penghargaans(): HasMany
    {
        return $this->hasMany(Penghargaan::class, 'peringkat_id', 'id');
    }
}
