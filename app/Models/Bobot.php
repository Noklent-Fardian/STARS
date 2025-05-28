<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    use HasFactory;

    protected $table = 'm_bobots'; // Nama tabel di database
    protected $primaryKey = 'id';  // Primary key default

    protected $fillable = [
        'kriteria',
        'bobot',
    ];
}