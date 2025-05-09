<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peringkat extends Model
{
    use HasFactory;

    protected $table = 'm_peringkats';

    protected $fillable = [
        'peringkat_nama',
        'peringkat_bobot',
        'peringkat_visible'
    ];
}
