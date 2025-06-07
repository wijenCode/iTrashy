<?php

/**
 * Model SetorItem
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// * Model ini merepresentasikan item sampah yang disetorkan oleh user
//  * dalam setiap transaksi penyetoran (`SetorSampah`).
class SetorItem extends Model
{
//  * Setiap item berisi informasi:
//  * - jenis sampah (relasi ke JenisSampah)
//  * - berat sampah (dalam kg)
//  * - poin yang diperoleh dari berat dan jenisnya
    use HasFactory;

    protected $table = 'setor_item';

    protected $fillable = [
        'setor_sampah_id',
        'jenis_sampah_id',
        'berat',
        'poin'
    ];
// * Relasi:
//  * - belongsTo SetorSampah: mengacu ke transaksi penyetoran utama
//  * - belongsTo JenisSampah: mengacu ke jenis sampah tertentu
    public function setorSampah()
    {
        return $this->belongsTo(SetorSampah::class);
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class);
    }
}