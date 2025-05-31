<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    use HasFactory;

    protected $table = 'm_bobots';
    
    protected $fillable = [
        'kriteria',
        'bobot',
    ];

    protected $casts = [
        'bobot' => 'float'
    ];

    // Konstanta untuk nama kriteria
    const KRITERIA_SCORE = 'score';
    const KRITERIA_KEAHLIAN_UTAMA = 'keahlian_utama';
    const KRITERIA_KEAHLIAN_TAMBAHAN = 'keahlian_tambahan';
    const KRITERIA_JUMLAH_LOMBA = 'jumlah_lomba';

    public static function getKriteriaLabels()
    {
        return [
            self::KRITERIA_SCORE => 'Skor Mahasiswa',
            self::KRITERIA_KEAHLIAN_UTAMA => 'Keahlian Utama',
            self::KRITERIA_KEAHLIAN_TAMBAHAN => 'Keahlian Tambahan',
            self::KRITERIA_JUMLAH_LOMBA => 'Pengalaman Lomba'
        ];
    }

    public function getKriteriaLabelAttribute()
    {
        $labels = self::getKriteriaLabels();
        return $labels[$this->kriteria] ?? $this->kriteria;
    }
}