<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminKelolaLomba extends Model
{
    use HasFactory;

    protected $table = 'm_lombas';

    protected $fillable = [
        'keahlian_id',
        'tingkatan_id',
        'semester_id',
        'lomba_nama',
        'lomba_penyelenggara',
        'lomba_kategori',
        'lomba_tanggal_mulai',
        'lomba_tanggal_selesai',
        'lomba_link_pendaftaran',
        'lomba_link_poster',
    ];
    public function keahlian(): BelongsTo
    {
        return $this->belongsTo(Keahlian::class, 'keahlian_id');
    }
    public function tingkatan(): BelongsTo
    {
        return $this->belongsTo(Tingkatan::class, 'tingkatan_id');
    }
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}