<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiSembako extends Model
{
    protected $table = 'transaksi_sembako';

    use HasFactory;

    protected $fillable = [
        'user_id', 'sembako_id', 'tanggal_transaksi', 'status'
    ];

    public function sembako()
    {
        return $this->belongsTo(Sembako::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
