<?php

namespace App\Http\Resources\Laporan;

use Illuminate\Http\Resources\Json\JsonResource;

class PemasukanKendaraanSendiriResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $status = "belum lunas";
        if ($this->status_kendaraan == "Sendiri") {
            $status = $this->harga_order_bersih <= $this->mutasi_order->sum('nominal') ? "lunas" : "belum lunas";
        }else{
            $status = $this->harga_order_bersih <= $this->mutasi_jual->sum('nominal') ? "lunas" : "belum lunas";
        }
        return [
            'tanggal' => $this->tanggal_awal,
            'no_transaksi' => $this->no_transaksi,
            'status' => $status,
            'status_kendaraan' => $this->status_kendaraan,
            'armada' => $this->armada,
            'sopir' => $this->sopir,
            'penyewa' => $this->penyewa,
            'muatan' => $this->muatan,
            'asal' => $this->asal,
            'tujuan' => $this->tujuan,
            'setor' => $this->setor,
        ];
    }
}
