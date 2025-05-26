<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_mahasiswas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'prodi_id',
        'keahlian_id',
        'mahasiswa_nama',
        'semester_id',
        'mahasiswa_nim',
        'mahasiswa_status',
        'mahasiswa_gender',
        'mahasiswa_angkatan',
        'mahasiswa_nomor_telepon',
        'mahasiswa_photo',
        'mahasiswa_agama',
        'mahasiswa_provinsi',
        'mahasiswa_kota',
        'mahasiswa_kecamatan',
        'mahasiswa_desa',
        'mahasiswa_score',
        'mahasiswa_visible',
    ];

    /**
     * Get the user that owns the mahasiswa.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the program studi that the mahasiswa belongs to.
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    /**
     * Get the keahlian that the mahasiswa has.
     */
    public function keahlian(): BelongsTo
    {
        return $this->belongsTo(Keahlian::class, 'keahlian_id');
    }
}
