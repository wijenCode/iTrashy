<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';

    protected $fillable = [
        'nama_donasi', 'deskripsi', 'donasi_terkumpul', 'target_donasi', 'gambar'
    ];

    public function transaksiDonasi()
    {
        return $this->hasMany(TransaksiDonasi::class);
    }
}
