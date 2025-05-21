<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telepon',
        'alamat',
        'kota',
        'kecamatan',
        'foto_profile',
        'poin_terkumpul',
        'sampah_terkumpul',
        'level',
        'role',
    ];

    // Relasi dengan SetorSampah
    public function setorSampah()
    {
        return $this->hasMany(SetorSampah::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User memiliki banyak edukasi
     */
    public function edukasi()
    {
        return $this->hasMany(Edukasi::class);
    }
}
