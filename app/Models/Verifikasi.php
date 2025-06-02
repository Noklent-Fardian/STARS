<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verifikasi extends Model
{
    use HasFactory;

    protected $table = 't_verifikasis';
    protected $primaryKey = 'id';

    protected $fillable = [
        'mahasiswa_id',
        'penghargaan_id',
        'dosen_id',
        'admin_id',
        'verifikasi_admin_status',
        'verifikasi_admin_keterangan',
        'verifikasi_admin_tanggal',
        'verifikasi_dosen_status',
        'verifikasi_dosen_keterangan',
        'verifikasi_dosen_tanggal',
        'verifikasi_visible'
    ];

    protected $casts = [
        'verifikasi_admin_tanggal' => 'datetime',
        'verifikasi_dosen_tanggal' => 'datetime',
        'verifikasi_visible' => 'boolean'
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function penghargaan(): BelongsTo
    {
        return $this->belongsTo(Penghargaan::class, 'penghargaan_id', 'id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
