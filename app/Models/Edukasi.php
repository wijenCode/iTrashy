<?php

// app/Models/Edukasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Edukasi extends Model
{
    use HasFactory;

    protected $table = 'edukasi';

    protected $fillable = [
        'user_id',
        'judul_konten',
        'konten',
        'gambar',
        'video_url',
        'jenis_konten',
        'kategori'
    ];

    // Define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
