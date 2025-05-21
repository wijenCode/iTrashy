<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sembako extends Model
{
    protected $table = 'sembako';

    use HasFactory;

    protected $fillable = [
        'nama_sembako', 'deskripsi', 'jumlah_barang', 'poin', 'gambar', 'status'
    ];

    public function transaksiSembako()
    {
        return $this->hasMany(TransaksiSembako::class);
    }
}
