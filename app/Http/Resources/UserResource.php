<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'no_telepon' => $this->no_telepon,
            'alamat' => $this->alamat,
            'kota' => $this->kota,
            'kecamatan' => $this->kecamatan,
            'foto_profile' => $this->foto_profile,
            'poin_terkumpul' => $this->poin_terkumpul,
            'sampah_terkumpul' => $this->sampah_terkumpul,
            'level' => $this->level,
            'role' => $this->role,
        ];
    }
}
