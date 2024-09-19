<?php
namespace App\Services;

use App\Repositories\Contracts\LaporanInterface;
use Illuminate\Http\Request;

class LaporanPemasukanKendaraanService
{
    protected $laporanPemasukan;

    public function __construct(LaporanInterface $laporanPemasukan)
    {
        $this->laporanPemasukan = $laporanPemasukan;
    }

    public function getLaporanPemasukanKendaraanSendiri(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $m_armada_id = $request->m_armada_id;
        return $this->laporanPemasukan->getLaporanPemasukanKendaraanSendiri($tanggal_awal,$tanggal_akhir, $m_armada_id);
    }

    public function getLaporanPemasukanKendaraanSubkon(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        return $this->laporanPemasukan->getLaporanPemasukanKendaraanSubkon($tanggal_awal,$tanggal_akhir);
    }
}