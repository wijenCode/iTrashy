<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSampah extends Model
{
    use HasFactory;

    protected $table = 'jenis_sampah';

    protected $fillable = [
        'nama_sampah',
        'poin_per_kg',
        'carbon_reduced',
        'kategori_sampah',
        'gambar'
    ];

    public function setorItems()
    {
        return $this->hasMany(SetorItem::class);
    }
}
