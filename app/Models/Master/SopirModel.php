<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SopirModel extends Model
{
    use HasFactory;
    protected $table = "master_sopir";
    protected $fillable =[
        'nama',
        'alamat',
        'ktp',
        'SIM',
        'keterangan',
        'tanggal_gabung',
        'nomor_hp'   
    ];
}
