<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiTransfer extends Model
{
    protected $table = 'transaksi_transfer';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'transfer_id',
        'tanggal_transaksi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke detail transfer di tabel 'transfer'
    public function transferDetail()
    {
        return $this->belongsTo(\App\Models\TransferDetail::class, 'transfer_id');
    }
}
