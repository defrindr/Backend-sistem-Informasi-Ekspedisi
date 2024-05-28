<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\ArmadaModel;
use App\Models\Transaksi\NotaBeliModel;

class ServisModel extends Model
{
    use HasFactory;
    protected $table = 'servis';
    protected $fillable = [
        'nama_toko',
        'tanggal_servis',
        'nota_beli_id',
        'master_armada_id',
        'kategori_servis',
    ];
    public function master_armada()
    {
        return $this->belongsTo(ArmadaModel::class);
    }

    public function nota_beli_items()
    {
        return $this->hasMany(NotaBeliModel::class, 'servis_id');
    }

    public function servis_mutasi()
    {
        return $this->hasMany(ServisMutasiModel::class, 'servis_id');
    }

    public function getAll($payload){
        $data =$this->with(['master_armada' => function ($query) {
            $query->select('id', 'nopol');
        }, 'nota_beli_items', 'nota_beli_items', 'servis_mutasi.master_mutasi'])->when(isset($payload['nota_beli_id']) && $payload['nota_beli_id'], function($query) use($payload){
            $query->where('nota_beli_id', $payload['nota_beli_id']);
        })->when(isset($payload['nama_toko'])&& $payload['nama_toko'],function($query) use($payload){
            $query->where('nama_toko',$payload['nama_toko']);
        })->when(isset($payload['tanggal_servis'])&& $payload['tanggal_servis'],function($query) use($payload){
            $query->where('tanggal_servis',$payload['tanggal_servis']);
        })->get();

        // hitung total
        $data->map(function($item){
            $total = 0;
            $item->nota_beli_items->map(function($item) use(&$total){
                $total_sub = $item->harga * $item->jumlah;
                $total += $total_sub;
                return $item;
            });
            $item->total = $total;
        });

        return $data;
    }


}
