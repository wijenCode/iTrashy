<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiDonasi extends Model
{
    protected $table = 'transaksi_donasi';

    use HasFactory;

protected $fillable = [
        'user_id', 'donasi_id', 'tanggal_transaksi', 'status'
    ];

    public function donasi()
    {
        return $this->belongsTo(Donasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
