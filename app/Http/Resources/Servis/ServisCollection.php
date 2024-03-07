<?php

namespace App\Http\Resources\Servis;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ServisCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_toko' => $this->nama_toko,
            'nota_beli_id' => $this->nota_beli_id,
            'nopol' => $this->armada->nopol, // Accessing nopol from the armada relationship
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
