<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiVoucher extends Model
{
    protected $table = 'transaksi_voucher';

    use HasFactory;

    protected $fillable = [
        'user_id', 'voucher_id', 'tanggal_transaksi', 'status'
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
