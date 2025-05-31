<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dosen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_dosens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'prodi_id',
        'dosen_nama',
        'dosen_nip',
        'dosen_status',
        'dosen_gender',
        'keahlian_id',
        'keahlian_sertifikat',
        'dosen_nomor_telepon',
        'dosen_photo',
        'dosen_agama',
        'dosen_provinsi',
        'dosen_kota',
        'dosen_kecamatan',
        'dosen_desa',
        'dosen_score',
        'dosen_visible',
    ];

    /**
     * Get the user that owns the dosen.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
    public function keahlianUtama()
    {
        return $this->belongsTo(Keahlian::class, 'keahlian_id');
    }

    public function keahlianTambahan()
    {
        return $this->belongsToMany(
            Keahlian::class,
            't_keahlian_dosens',
            'dosen_id',
            'keahlian_id'
        )->withPivot('keahlian_sertifikat');
    }
}