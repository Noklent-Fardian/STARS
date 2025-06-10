<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 't_bimbingans';

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id', 
        'lomba_id',
        'bimbingan_status',
        'bimbingan_visible'
    ];

    protected $casts = [
        'bimbingan_visible' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(\App\Models\Mahasiswa::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(\App\Models\Dosen::class, 'dosen_id');
    }

    public function lomba()
    {
        return $this->belongsTo(\App\Models\Lomba::class, 'lomba_id');
    }

    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('bimbingan_visible', true);
    }

    public function scopeBerlangsung($query)
    {
        return $query->where('bimbingan_status', 'berlangsung');
    }

    public function scopeSelesai($query)
    {
        return $query->where('bimbingan_status', 'selesai');
    }

    // Helper methods
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'berlangsung' => 'warning',
            'selesai' => 'success',
            'batal' => 'danger'
        ];
        
        return $statuses[$this->bimbingan_status] ?? 'secondary';
    }
}
