<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeahlianDosen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_keahlian_dosens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dosen_id',
        'keahlian_id',
        'keahlian_sertifikat',
    ];

    /**
     * Get the dosen that owns the keahlian.
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    /**
     * Get the keahlian associated with the dosen.
     */
    public function keahlian(): BelongsTo
    {
        return $this->belongsTo(Keahlian::class, 'keahlian_id');
    }
}
