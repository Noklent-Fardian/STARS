<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the program studi that the dosen belongs to.
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
}