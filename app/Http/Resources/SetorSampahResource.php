<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SetorSampahResource extends JsonResource
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
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'email' => $this->user->email,
                'no_telepon' => $this->user->no_telepon,
                'alamat' => $this->user->alamat,
                'kota' => $this->user->kota,
                'kecamatan' => $this->user->kecamatan
            ],
            'driver' => $this->when($this->driver, [
                'id' => $this->driver?->id,
                'username' => $this->driver?->username,
                'email' => $this->driver?->email,
                'no_telepon' => $this->driver?->no_telepon
            ]),
            'alamat' => $this->alamat,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'kode_kredensial' => $this->when(
                $this->status !== 'menunggu' || $request->user()->id === $this->user_id,
                $this->kode_kredensial
            ),
            'tanggal_setor' => $this->tanggal_setor->format('Y-m-d'),
            'waktu_setor' => $this->waktu_setor,
            'tanggal_diambil' => $this->when($this->tanggal_diambil, $this->tanggal_diambil?->format('Y-m-d H:i:s')),
            'catatan_driver' => $this->catatan_driver,
            'items' => SetorItemResource::collection($this->whenLoaded('setorItems')),
            'total_poin' => $this->total_poin,
            'total_berat' => $this->total_berat,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Get status label in Indonesian
     */
    private function getStatusLabel()
    {
        $statusLabels = [
            'menunggu' => 'Menunggu Penjemputan',
            'diambil' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return $statusLabels[$this->status] ?? $this->status;
    }
}