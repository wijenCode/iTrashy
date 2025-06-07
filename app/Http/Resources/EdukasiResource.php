<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EdukasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'konten' => $this->konten,
            'gambar' => $this->gambar ? asset('storage/' . $this->gambar) : null,
            'created_at' => $this->created_at->format('d M Y H:i:s'),
            'updated_at' => $this->updated_at->format('d M Y H:i:s'),
        ];
    }
}
