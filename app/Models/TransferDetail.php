<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferDetail extends Model
{
    use HasFactory;

    protected $table = 'transfer';

    protected $fillable = [
        'user_id',
        'e_wallet',
        'no_telepon',
        'bank',
        'poin_ditukar',
        'jumlah_transfer',
        'admin_fee',
        'total_transfer',
        // 'status', // Dihapus karena tidak ada di tabel 'transfer'
        // 'catatan', // Dihapus karena tidak ada di tabel 'transfer'
    ];

    // Relasi ke User jika diperlukan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 