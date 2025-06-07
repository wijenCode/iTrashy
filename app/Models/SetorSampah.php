<?php
/**
 * Model SetorSampah
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SetorSampah extends Model
{
//  * Model ini merepresentasikan data penyetoran sampah oleh user.
//  * Fungsinya mencakup:
//  * - Relasi dengan user (penyetor) dan driver (pengambil)
//  * - Menyimpan informasi alamat, status, waktu setor & ambil
//  * - Mengelola daftar item yang disetorkan
//  * - Menghitung total poin & berat dari item
//  * - Membuat kode kredensial unik untuk validasi
    use HasFactory;

    protected $table = 'setor_sampah';

    protected $fillable = [
        'user_id',
        'driver_id',
        'alamat',
        'status',
        'kode_kredensial',
        'tanggal_setor',
        'waktu_setor',
        'tanggal_diambil',
        'catatan_driver'
    ];

    protected $casts = [
        'tanggal_setor' => 'date',
        'tanggal_diambil' => 'datetime',
    ];

//  * Status yang digunakan:
//  * - menunggu, dikonfirmasi, diambil, ditolak, selesai
   
    // Status konstanta
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DIKONFIRMASI = 'dikonfirmasi';
    const STATUS_DIAMBIL = 'diambil';
    const STATUS_DITOLAK = 'ditolak';
    const STATUS_SELESAI = 'selesai';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function setorItems()
    {
        return $this->hasMany(SetorItem::class);
    }

    /**
     * Generate kode kredensial random
     */
    public function generateKodeKredensial()
    {
        $this->kode_kredensial = strtoupper(substr(md5(uniqid()), 0, 6));
        $this->save();
        return $this->kode_kredensial;
    }

    /**
     * Get total poin dari items
     */
    public function getTotalPoinAttribute()
    {
        return $this->setorItems->sum('poin');
    }

    /**
     * Get total berat dari items
     */
    public function getTotalBeratAttribute()
    {
        return $this->setorItems->sum('berat');
    }
}