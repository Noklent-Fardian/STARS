<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penghargaan extends Model
{
    use HasFactory;

    protected $table = 'm_penghargaans';

    protected $fillable = [
        'mahasiswa_id',
        'lomba_id',
        'peringkat_id',
        'tingkatan_id',
        'penghargaan_judul',
        'penghargaan_tempat',
        'penghargaan_url',
        'penghargaan_tanggal_mulai',
        'penghargaan_tanggal_selesai',
        'penghargaan_jumlah_peserta',
        'penghargaan_jumlah_instansi',
        'penghargaan_no_surat_tugas',
        'penghargaan_tanggal_surat_tugas',
        'penghargaan_file_surat_tugas',
        'penghargaan_file_sertifikat',
        'penghargaan_file_poster',
        'penghargaan_photo_kegiatan',
        'penghargaan_score',
        'penghargaan_visible',
    ];

    protected $casts = [
        'penghargaan_tanggal_mulai' => 'date',
        'penghargaan_tanggal_selesai' => 'date',
        'penghargaan_tanggal_surat_tugas' => 'date',
        'penghargaan_visible' => 'boolean',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function lomba(): BelongsTo
    {
        return $this->belongsTo(Lomba::class, 'lomba_id');
    }

    public function peringkat(): BelongsTo
    {
        return $this->belongsTo(Peringkat::class, 'peringkat_id');
    }

    public function tingkatan(): BelongsTo
    {
        return $this->belongsTo(Tingkatan::class, 'tingkatan_id');
    }
}
