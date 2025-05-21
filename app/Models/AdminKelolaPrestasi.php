<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminKelolaPrestasi extends Model
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

    // Relasi ke tabel mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    // Relasi ke tabel lomba
    public function lomba()
    {
        return $this->belongsTo(AdminKelolaLomba::class, 'lomba_id');
    }
    
    // Relasi ke tabel peringkat
    public function peringkat()
    {
        return $this->belongsTo(Peringkat::class, 'peringkat_id');
    }

    // Relasi ke tabel tingkatan
    public function tingkatan()
    {
        return $this->belongsTo(Tingkatan::class, 'tingkatan_id');
    }
}
