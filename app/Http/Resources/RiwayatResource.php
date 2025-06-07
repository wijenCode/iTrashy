<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class RiwayatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'status' => $this->status,
            'poin' => $this->poin,
            'date' => Carbon::parse($this->date)->format('d M Y H:i:s'),
            'desc' => $this->desc,
        ];

        switch ($this->type) {
            case 'Setor Sampah':
                $data['jenis_sampah'] = $this->jenis_sampah;
                $data['berat'] = $this->berat;
                $data['alamat'] = $this->alamat;
                break;
            case 'Transfer':
                $data['penerima'] = $this->penerima;
                $data['nomor_penerima'] = $this->nomor_penerima;
                break;
            case 'Voucher':
                $data['kode'] = $this->kode;
                $data['jenis_voucher'] = $this->jenis_voucher;
                $data['nilai_voucher'] = $this->nilai_voucher;
                break;
            case 'Sembako':
                $data['jenis_sembako'] = $this->jenis_sembako;
                $data['jumlah'] = $this->jumlah;
                break;
            case 'Donasi':
                $data['lembaga'] = $this->lembaga;
                $data['jenis_donasi'] = $this->jenis_donasi;
                break;
        }

        return $data;
    }
}
