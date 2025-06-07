<?php

// * Model JenisSampah

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Model ini merepresentasikan data master untuk jenis-jenis sampah
//  yang dapat disetorkan oleh pengguna dalam sistem.
class JenisSampah extends Model
{
    use HasFactory;

    protected $table = 'jenis_sampah';

//  * Informasi yang dikelola mencakup:
//  * - nama_sampah: nama jenis sampah (contoh: plastik, kertas)
//  * - poin_per_kg: poin yang diperoleh per kilogram sampah
//  * - carbon_reduced: jumlah karbon yang dikurangi per kg
//  * - kategori_sampah: kategori atau grup sampah
//  * - gambar: URL atau path ke gambar ilustrasi jenis sampah
    protected $fillable = [
        'nama_sampah',
        'poin_per_kg',
        'carbon_reduced',
        'kategori_sampah',
        'gambar'
    ];

//  * Relasi:
//  * - hasMany SetorItem: digunakan untuk mencatat semua penyetoran
//  *   yang terkait dengan jenis sampah ini.
    public function setorItems()
    {
        return $this->hasMany(SetorItem::class);
    }
}
