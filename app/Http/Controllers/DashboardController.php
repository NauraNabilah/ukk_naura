<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\detailPenjualan;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $jmlTrans = Penjualan::whereDate('created_at', Carbon::today())->count();
    
        $produkTerjual = detailPenjualan::selectRaw('id_produk, SUM(jumlah) as total_terjual')
            ->groupBy('id_produk')
            ->with('produk') 
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->produk->nama_produk ?? 'Tidak diketahui',
                    'jumlah' => $item->total_terjual
                ];
            });
    

            $transaksiHarian = Penjualan::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get();
            
        return view('dashboard.index', compact('jmlTrans', 'produkTerjual', 'transaksiHarian'));
    }

    // public function penjualanHari()

}
