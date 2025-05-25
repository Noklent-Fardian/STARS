<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompetitionSubmission extends Model
{
    use HasFactory;

    protected $table = 't_request_tambah_lombas';

    protected $fillable = [
        'mahasiswa_id',
        'lomba_id',
        'lomba_nama',
        'lomba_penyelenggara',
        'lomba_kategori',
        'lomba_tanggal_mulai',
        'lomba_tanggal_selesai',
        'lomba_link_pendaftaran',
        'lomba_link_poster',
        'lomba_tingkatan_id',
        'lomba_keahlian_ids', // Store as JSON array
        'pendaftaran_status',
        'pendaftaran_visible'
    ];

    protected $casts = [
        'lomba_tanggal_mulai' => 'date',
        'lomba_tanggal_selesai' => 'date',
        'lomba_keahlian_ids' => 'array', // Cast to array
        'pendaftaran_visible' => 'boolean'
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function tingkatan(): BelongsTo
    {
        return $this->belongsTo(Tingkatan::class, 'lomba_tingkatan_id');
    }

    // Get keahlian names for display
    public function getKeahlianNamesAttribute()
    {
        if (!$this->lomba_keahlian_ids || empty($this->lomba_keahlian_ids)) {
            return '';
        }

        $keahlians = Keahlian::whereIn('id', $this->lomba_keahlian_ids)->get();
        return $keahlians->pluck('keahlian_nama')->join(', ');
    }

    // Get keahlian objects for display
    public function getKeahliansAttribute()
    {
        if (!$this->lomba_keahlian_ids || empty($this->lomba_keahlian_ids)) {
            return collect();
        }

        return Keahlian::whereIn('id', $this->lomba_keahlian_ids)->get();
    }
    public function lomba(): BelongsTo
    {
        return $this->belongsTo(Lomba::class, 'lomba_id');
    }
}
