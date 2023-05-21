<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanResource extends JsonResource
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
            'tanggal' => date('M/d/Y', strtotime($this->tanggal)),
            'waktu' => $this->waktu,
            'username' => $this->username,
            'profil' => $this->profil,
            'komentar' => $this->komentar,
            'harga' => $this->harga,
            'total' => $this->harga,
        ];
    }
}
