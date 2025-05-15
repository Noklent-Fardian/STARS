<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'm_semesters';

    /**
     * Kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'semester_nama',
        'semester_tahun',
        'semester_jenis',
        'semester_aktif',
        'semester_visible'
    ];

    /**
     * Kolom yang harus disembunyikan saat serialisasi.
     *
     * @var array
     */
    protected $hidden = [
        // Tambahkan kolom yang ingin disembunyikan jika ada
    ];

    /**
     * Casting tipe data untuk atribut tertentu.
     *
     * @var array
     */
    protected $casts = [
        'semester_aktif' => 'boolean',
        'semester_visible' => 'boolean',
        'semester_tahun' => 'integer',
    ];

    /**
     * Scope untuk semester aktif
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAktif($query)
    {
        return $query->where('semester_aktif', true);
    }

    /**
     * Scope untuk semester yang visible
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('semester_visible', true);
    }

    /**
     * Scope untuk semester berdasarkan jenis
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $jenis
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('semester_jenis', $jenis);
    }
}