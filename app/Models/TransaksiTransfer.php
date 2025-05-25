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
        'jenis_transfer',
        'bank',
        'e_wallet',
        'nama_penerima',
        'nomor_rekening',
        'nomor_ponsel',
        'jumlah_transfer',
        'biaya_admin',
        'total_transfer',
        'status',
        'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
