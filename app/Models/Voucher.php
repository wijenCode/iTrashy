<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    protected $table = 'voucher';

    use HasFactory;

    protected $fillable = [
        'nama_voucher', 'deskripsi', 'jumlah_voucher', 'poin', 'gambar', 'status'
    ];

    public function transaksiVoucher()
    {
        return $this->hasMany(TransaksiVoucher::class);
    }
}
