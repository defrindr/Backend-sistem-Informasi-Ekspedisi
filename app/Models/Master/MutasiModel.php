<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\RekeningModel;
use App\Models\Transaksi\OrderModel;
use App\Models\User;

class MutasiModel extends Model
{
    use HasFactory;
    protected $table = 'master_mutasi';
    protected $fillable = [
        'transaksi_order_id',
        'jenis_transaksi', // 'order' or 'jual
        'master_rekening_id',
        'nominal',
        'tanggal_pembayaran',
        'keterangan',
    ];
    public function master_rekening()
    {
        return $this->belongsTo(RekeningModel::class);
    }
    public function transaksi_order()
    {
        return $this->hasOne(OrderModel::class);
    }

    public function getAll($payload){
        $data = $this->
        with(['pembuat'])
        ->when(isset($payload['transaksi_order_id']) && $payload['transaksi_order_id'], function($query) use($payload){
            $query->where('transaksi_order_id', $payload['transaksi_order_id']);
        })->when(isset($payload['master_rekening_id']) && $payload['master_rekening_id'], function($query) use($payload){
            $query->where('master_rekening_id', $payload['master_rekening_id']);
        })->when(isset($payload['tanggal_pembayaran']) && $payload['tanggal_pembayaran'], function($query) use($payload){
            $query->where('tanggal_pembayaran', $payload['tanggal_pembayaran']);
        })->when(isset($payload['keterangan']) && $payload['keterangan'], function($query) use($payload){
            $query->where('keterangan', $payload['keterangan']);
        })->when(isset($payload['jenis_transaksi']) && $payload['jenis_transaksi'], function($query) use($payload){
            $query->where('jenis_transaksi', $payload['jenis_transaksi']);
        })
        ->get();
        return $data;
    }

    public function pembuat(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
