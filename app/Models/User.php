<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'user_password',
        'user_role',
        'user_visible',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_visible' => 'boolean',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    /**
     * Get the mahasiswa associated with the user.
     */
    public function mahasiswa(): HasOne
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }

    /**
     * Get the dosen associated with the user.
     */
    public function dosen(): HasOne
    {
        return $this->hasOne(Dosen::class, 'user_id');
    }

    /**
     * Get the admin associated with the user.
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->user_role === 'Admin';
    }

    /**
     * Determine if the user is a dosen.
     *
     * @return bool
     */
    public function isDosen(): bool
    {
        return $this->user_role === 'Dosen';
    }

    /**
     * Determine if the user is a mahasiswa.
     *
     * @return bool
     */
    public function isMahasiswa(): bool
    {
        return $this->user_role === 'Mahasiswa';
    }
}