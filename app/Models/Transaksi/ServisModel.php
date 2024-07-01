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
        'nomor_nota',
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
        }, 'nota_beli_items', 'nota_beli_items', 'servis_mutasi.master_mutasi.master_rekening'])->when(isset($payload['nota_beli_id']) && $payload['nota_beli_id'], function($query) use($payload){
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

        // hitung total mutasi
        $data->map(function($item){
            $total = 0;
            $item->servis_mutasi->map(function($item) use(&$total){
                $total += ($item->master_mutasi->nominal ?? 0);
                return $item;
            });
            $item->total_mutasi = $total;
        });

        return $data;
    }

    public function getAllServis($payload){
        $data =$this->with(['master_armada' => function ($query) {
            $query->select('id', 'nopol');
        }, 'nota_beli_items', 'nota_beli_items', 'servis_mutasi.master_mutasi.master_rekening'])->when(isset($payload['nota_beli_id']) && $payload['nota_beli_id'], function($query) use($payload){
            $query->where('nota_beli_id', $payload['nota_beli_id']);
        })->when(isset($payload['nama_toko'])&& $payload['nama_toko'],function($query) use($payload){
            $query->where('nama_toko',$payload['nama_toko']);
        })->when(isset($payload['tanggal_servis'])&& $payload['tanggal_servis'],function($query) use($payload){
            $query->where('tanggal_servis',$payload['tanggal_servis']);
        })
        ->where('kategori_servis', 'servis')
        // search
        ->when(isset($payload['search']) && $payload['search'],function($query) use ($payload){
            $query->orWhere('nama_toko', 'like', '%'.$payload['search'].'%');
            $query->orWhere('nomor_nota', 'like', '%'.$payload['search']. '%');
        })
        ->get();

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

        // hitung total mutasi
        $data->map(function($item){
            $total = 0;
            $item->servis_mutasi->map(function($item) use(&$total){
                $total += ($item->master_mutasi->nominal ?? 0);
                return $item;
            });
            $item->total_mutasi = $total;
        });

        return $data;
    }

    public function getAllLainLain($payload){
        $data =$this->with(['master_armada' => function ($query) {
            $query->select('id', 'nopol');
        }, 'nota_beli_items', 'nota_beli_items', 'servis_mutasi.master_mutasi.master_rekening'])->when(isset($payload['nota_beli_id']) && $payload['nota_beli_id'], function($query) use($payload){
            $query->where('nota_beli_id', $payload['nota_beli_id']);
        })->when(isset($payload['nama_toko'])&& $payload['nama_toko'],function($query) use($payload){
            $query->where('nama_toko',$payload['nama_toko']);
        })->when(isset($payload['tanggal_servis'])&& $payload['tanggal_servis'],function($query) use($payload){
            $query->where('tanggal_servis',$payload['tanggal_servis']);
        })
        ->where('kategori_servis', 'lain')
        // search
        ->when(isset($payload['search']) && $payload['search'],function($query) use ($payload){
            $query->where('nama_tujuan_lain', 'like', '%'.$payload['search'].'%');
            $query->orWhere('keterangan_lain', 'like', '%'.$payload['search'].'%');
            $query->orWhere('nominal_lain', 'like', '%'.$payload['search'].'%');
            $query->orWhere('jumlah_lain', 'like', '%'.$payload['search'].'%');
            $query->orWhere('total_lain', 'like', '%'.$payload['search'].'%');
            $query->orWhere('nama_toko', 'like', '%'.$payload['search'].'%');
            $query->orWhere('nomor_nota', 'like', '%'.$payload['search']. '%');
        })
        ->get();

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

        // hitung total mutasi
        $data->map(function($item){
            $total = 0;
            $item->servis_mutasi->map(function($item) use(&$total){
                $total += ($item->master_mutasi->nominal ?? 0);
                return $item;
            });
            $item->total_mutasi = $total;
        });

        return $data;
    }


}
