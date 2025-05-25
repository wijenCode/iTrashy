<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SetorItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'jenis_sampah' => [
                'id' => $this->jenisSampah->id,
                'nama_sampah' => $this->jenisSampah->nama_sampah,
                'poin_per_kg' => $this->jenisSampah->poin_per_kg,
                'carbon_reduced' => $this->jenisSampah->carbon_reduced,
                'kategori_sampah' => $this->jenisSampah->kategori_sampah,
                'gambar' => $this->jenisSampah->gambar
            ],
            'berat' => (float) $this->berat,
            'poin' => (int) $this->poin,
            'poin_sebelum_fee' => (float) ($this->jenisSampah->poin_per_kg * $this->berat),
            'fee_percentage' => 20,
            'carbon_reduced_total' => (float) ($this->jenisSampah->carbon_reduced * $this->berat)
        ];
    }
}