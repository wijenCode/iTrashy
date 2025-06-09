<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    protected $table = 'transfer';

    use HasFactory;

    protected $fillable = [
        'user_id', 'e_wallet', 'no_telepon', 'bank', 'poin_ditukar', 'jumlah_transfer', 'admin_fee', 'total_transfer'
    ];

    public function transaksiTransfer()
    {
        return $this->hasMany(TransaksiTransfer::class);
    }
}
