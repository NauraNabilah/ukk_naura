<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $penjualan->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .summary-table td { padding: 6px; }
        .mt-2 { margin-top: 10px; }
        .mt-4 { margin-top: 20px; }
        .fw-bold { font-weight: bold; }
        .footer { margin-top: 30px; font-size: 12px; text-align: center; }
    </style>
</head>
<body>

    <h3>Alat Solat</h3>

    <p>
        Member Status : {{ $penjualan->member ? 'Member' : 'Bukan Member' }}<br>
        No. HP : {{ $penjualan->member->phone ?? '-' }}<br>
        Bergabung Sejak : {{ $penjualan->member ? \Carbon\Carbon::parse($penjualan->member->created_at)->translatedFormat('d F Y') : '-' }}<br>
        Poin Member : {{ $penjualan->member->poin ?? '-' }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>QTy</th>
                <th>Harga</th>
                <th class="text-end">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan->detailPenjualan as $detail)
            <tr>
                <td>{{ $detail->produk->nama_produk ?? '-' }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td class="text-end">Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary-table mt-4">
        
        <tr>
            <td>Poin Digunakan</td>
            <td class="text-end">{{ $penjualan->point_earned ?? 0 }}</td>
        </tr>
        <tr>
            <td><strong>Total Harga</strong></td>
            <td class="text-end">Rp. {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Uang Diberi</strong></td>
            <td class="text-end">Rp. {{ number_format($penjualan->uang_diberi, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Kembalian</strong></td>
            <td class="text-end">Rp. {{ number_format($penjualan->uang_kembali + $penjualan->point_earned, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        {{ $penjualan->tanggal }} | {{ $penjualan->petugas }}<br>
        <strong>Terima kasih atas pembelian Anda!</strong>
    </div>

</body>
</html>


