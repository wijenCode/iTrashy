<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SetorItem extends Model
{
    use HasFactory;

    protected $table = 'setor_item';

    protected $fillable = [
        'setor_sampah_id',
        'jenis_sampah_id',
        'berat',
        'poin'
    ];

    public function setorSampah()
    {
        return $this->belongsTo(SetorSampah::class);
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class);
    }
}