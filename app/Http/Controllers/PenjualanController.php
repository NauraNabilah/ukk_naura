<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\detailPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::paginate(10);
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('penjualan.create', compact('produks'));
    }

    public function pembayaran($id)
    {
        $penjualan = Penjualan::with('member')->findOrFail($id);
        return view('penjualan.pembayaran', compact('penjualan'));
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['member', 'detailPenjualan.produk'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'detail' => 'required|array',
            'detail.*.id_produk' => 'required|exists:Produks,id',
            'detail.*.jumlah' => 'required|integer|min:1',
            'petugas' => 'required|string|max:255',
            'uang_diberi' => 'required|numeric|min:0',
            'phone' => 'nullable|string|max:20',
            'member' => 'required|string', 
            'gunakan_poin' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            $totalHarga = 0;
            $idMember = null;
            $poinDipakai = 0;

            foreach ($request->detail as $item) {
                $produk = Produk::lockForUpdate()->find($item['id_produk']);
                if ($item['jumlah'] > $produk->stok) {
                    throw new \Exception("Stok untuk {$produk->nama_produk} tidak cukup.");
                }
                $totalHarga += $produk->harga * $item['jumlah'];
            }

            if ($request->member === 'Member' && $request->phone) {
                $member = Member::where('phone', $request->phone)->first();

                if ($member && $request->gunakan_poin && $member->poin > 0) {
                    $poinDipakai = min($member->poin, $totalHarga);
                    $totalHarga -= $poinDipakai;
                    $member->poin -= $poinDipakai;
                    $member->save();
                    $idMember = $member->id;
                }
            }

            $penjualan = Penjualan::create([
                'tanggal' => $request->tanggal,
                'id_member' => $idMember,
                'total_harga' => $totalHarga,
                'uang_diberi' => $request->uang_diberi,
                'uang_kembali' => $request->uang_diberi - $totalHarga,
                'petugas' => $request->petugas,
            ]);

            foreach ($request->detail as $item) {
                $produk = Produk::lockForUpdate()->find($item['id_produk']);
                $sub_total = $produk->harga * $item['jumlah'];

                detailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $produk->harga,
                    'sub_total' => $sub_total,
                ]);

                $produk->stok -= $item['jumlah'];
                $produk->save();
            }

            $penjualan->update([
                'total_harga' => $totalHarga,
                'uang_kembali' => $request->uang_diberi - $totalHarga,
                'point_used' => $poinDipakai,
                'point_earned' => $idMember ? floor($totalHarga * 0.01) : 0,
            ]);
            

            DB::commit();

            if ($request->member === 'Member') {
                if (empty($request->phone)) {
                    return redirect()->back()->with('error', 'Nomor telepon harus diisi untuk member!');
                }

                $existingMember = Member::where('phone', $request->phone)->first();

                if ($existingMember && $idMember) {
                    return redirect()->route('penjualan.hasil', $penjualan->id)
                        ->with('success', 'Transaksi berhasil! Poin telah digunakan.');
                }

                return redirect()->route('penjualan.add-member', [
                    'id' => $penjualan->id,
                    'phone' => $request->phone,
                    'existing' => $existingMember ? 'true' : 'false',
                    'poin_dipakai' => $poinDipakai,
                ]);
            }

            return redirect()->route('penjualan.hasil', $penjualan->id)
                ->with('success', 'Transaksi berhasil tanpa member!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transaksi gagal: ' . $e->getMessage());
        }
    }



    public function rincian(Request $request)
    {
        $produkDipilih = [];
        $totalHarga = 0;

        foreach ($request->produks as $id => $jumlah) {
            if ($jumlah > 0) {
                $produk = Produk::find($id);
                $subtotal = $produk->harga * $jumlah;
                $produkDipilih[] = [
                    'id' => $produk->id,
                    'nama_produk' => $produk->nama_produk,
                    'harga' => $produk->harga,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal
                ];
                $totalHarga += $subtotal;
            }
        }

        session([
            'produkDipilih' => $produkDipilih,
            'totalHarga' => $totalHarga,
        ]);

        return redirect()->route('penjualan.rincian.view');
    }

    public function rincianView()
    {
        $produkDipilih = session('produkDipilih');
        $totalHarga = session('totalHarga');

        if (!$produkDipilih || !$totalHarga) {
            return redirect()->route('penjualan.create')->with('error', 'Tidak ada data produk dipilih.');
        }

        return view('penjualan.rincian', compact('produkDipilih', 'totalHarga'));
    }
    
    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            return response()->json(['message' => 'Penjualan tidak ditemukan'], 404);
        }

        $request->validate([
            'tanggal' => 'sometimes|date',
            'total_harga' => 'sometimes|numeric',
            'detail' => 'sometimes|array',
            'detail.*.id_produk' => 'sometimes|exists:Produks,id',
            'detail.*.jumlah' => 'sometimes|integer|min:1',
            'detail.*.harga' => 'sometimes|numeric',
            'detail.*.sub_total' => 'sometimes|numeric',
        ]);

        $penjualan->update($request->only(['tanggal', 'total_harga']));

        if ($request->has('detail')) {
            $penjualan->detailPenjualan()->delete();

            foreach ($request->detail as $item) {
                detailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'sub_total' => $item['sub_total'],
                ]);
            }
        }

        return response()->json([
            'message' => 'Penjualan berhasil diperbarui',
            'penjualan' => $penjualan
        ]);
    }

    public function addMember($id)
    {
        $penjualan = Penjualan::where('id', $id)
            ->with(['detailPenjualan.produk'])
            ->first();
    
        if (!$penjualan) {
            return redirect()->route('penjualan.index')->with('error', 'Penjualan tidak ditemukan');
        }
    
        $phone = request('phone');
        $existing = request('existing') === 'true';
        $poinDipakai = request('poin_dipakai', 0);
        $member = null;
    
        if ($existing) {
            $member = Member::where('phone', $phone)
                 ->select('id', 'name', 'phone', 'poin')
                ->with('penjualans') 
                ->first();
        }
    
        return view('penjualan.add-member', [
            'penjualan' => $penjualan,
            'phone' => $phone,
            'detailPenjualan' => $penjualan->detailPenjualan,
            'existingMember' => $member,
            'existing' => $existing,
            'poinDipakai' => $poinDipakai
        ]);
    }

    public function storeMember(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:penjualan,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'poin' => 'required|numeric|min:0',
            'check_poin' => 'nullable|string',
        ]);
    
        $penjualan = Penjualan::findOrFail($request->sale_id);
    
        $member = Member::where('phone', $request->phone)->first();
        $transaksiSebelumnya = 0;
        $gunakanPoin = $request->has('check_poin');
        $poinDigunakan = 0; 
    
        if ($member) {
            $transaksiSebelumnya = Penjualan::where('id_member', $member->id)->count();

            $poinSaatIni = $member->poin;
            $poinBaru = floor($penjualan->total_harga * 0.01);
    
            if ($transaksiSebelumnya > 0 && $gunakanPoin && $poinSaatIni > 0) {
                $poinDigunakan = min($poinSaatIni, $penjualan->total_harga);
                $penjualan->total_harga -= $poinDigunakan;
                $member->poin -= $poinDigunakan;
            }
    
            if ($transaksiSebelumnya > 0) {
                $member->poin += $poinBaru;
            }
    
            $member->save();
        } else {
            $member = Member::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'poin' => 0,
            ]);
        }
    
        $penjualan->update([
            'id_member' => $member->id,
            'point_earned' => $poinDigunakan, 
        ]);
    
        return redirect()->route('penjualan.hasil', $penjualan->id)
            ->with('success', 'Transaksi berhasil! Member ' . $member->name . ' mendapatkan poin.');
    }
    
    

    public function hasil($id)
    {
        $penjualan = Penjualan::with(['member', 'detailPenjualan.produk'])->findOrFail($id);
        return view('penjualan.hasil', compact('penjualan'));
    }

    public function unduhPdf($id)
    {
        $penjualan = Penjualan::with(['detailPenjualan.produk', 'member'])->findOrFail($id);

        $pdf = Pdf::loadView('penjualan.pdf', compact('penjualan'));
        return $pdf->download('penjualan-pdf' . $penjualan->id . '.pdf');
    }

    public function exportExcel()
    {
        $penjualans = \App\Models\Penjualan::with(['member', 'detailPenjualan.produk'])->get();

        $output = '
        <table border="1">
            <thead>
                <tr>
                    <th>Nama Member</th>
                    <th>No HP</th>
                    <th>Poin</th>
                    <th>Produk</th>
                    <th>Total Harga</th>
                    <th>Total Bayar</th>
                    <th>Total Diskon</th>
                    <th>Total Kembalian</th>
                    <th>Tanggal Pembelian</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($penjualans as $p) {
            $produkList = '';
            foreach ($p->detailPenjualan as $detail) {
                $produkList .= $detail->produk->nama_produk . ' (' . $detail->jumlah . 'x), ';
            }
            $produkList = rtrim($produkList, ', ');

            $output .= '
            <tr>
                <td>' . ($p->member->name ?? '-') . '</td>
                <td>' . ($p->member->phone ?? '-') . '</td>
                <td>' . ($p->member->poin ?? '-') . '</td>
                <td>' . $produkList . '</td>
                <td>' . number_format($p->total_harga, 0, ',', '.') . '</td>
                <td>' . number_format($p->uang_diberi, 0, ',', '.') . '</td>
                <td>' . number_format($p->point_earned ?? 0, 0, ',', '.') . '</td>
                <td>' . number_format($p->uang_kembali, 0, ',', '.') . '</td>
                <td>' . \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d F Y') . '</td>
            </tr>';
        }

        $output .= '</tbody></table>';

        return Response::make($output, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="penjualan.xls"',
        ]);
    }
}