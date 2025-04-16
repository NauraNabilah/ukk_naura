@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="bg-white p-4 shadow rounded">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('penjualan.unduh', $penjualan->id) }}" class="btn btn-primary">Unduh</a>
                    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="text-end">
                    <strong>Invoice – #{{ $penjualan->id }}</strong><br>
                    {{ \Carbon\Carbon::parse($penjualan->tanggal)->translatedFormat('d F Y') }}
                </div>
            </div>

            @if ($penjualan->member)
                <div class="mt-4">
                    <strong>{{ $penjualan->member->phone }}</strong>
                    <p>MEMBER SEJAK: {{ \Carbon\Carbon::parse($penjualan->member->created_at)->translatedFormat('d F Y') }}</p>
                    <p>MEMBER POIN SEKARANG: {{ $penjualan->member->poin }} poin</p>
                </div>
            @endif

            <table class="table table-borderless">
                <thead class="border-bottom">
                    <tr class="text-muted">
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th class="text-end">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan->detailPenjualan as $detail)
                        <tr>
                            <td>{{ $detail->produk->nama_produk ?? '-' }}</td>
                            <td>Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td class="text-end">Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between mt-4 bg-light p-3 rounded flex-wrap">
                @if ($penjualan->point_used > 0)
                    <div class="mb-3 me-4">
                        <p class="mb-1">POIN DIGUNAKAN</p>
                        <p class="fw-bold mb-0">{{ $penjualan->point_used }} poin</p>
                    </div>
                @endif
            
                @if ($penjualan->point_earned > 0)
                    <div class="mb-3 me-4">
                        <p class="mb-1">POINT DIGUNAKAN</p>
                        <p class="fw-bold mb-0">{{ $penjualan->point_earned }} poin</p>
                    </div>
                @endif
            
                <div class="mb-3 me-4">
                    <p class="mb-1">KASIR</p>
                    <p class="fw-bold mb-0">{{ $penjualan->petugas }}</p>
                </div>
            
                <div class="mb-3 me-4">
                    <p class="mb-1">KEMBALIAN</p>
                    <p class="fw-bold mb-0">Rp. {{ number_format($penjualan->uang_kembali + $penjualan->point_earned, 0, ',', '.') }}</p>
                </div>
            
                <div class="text-end ms-auto">
                    <p class="mb-1 text-muted">TOTAL HARGA</p>
                    <h4 class="fw-bold mb-0">Rp. {{ number_format($penjualan->total_harga, 0, ',', '.') }}</h4>
                </div>
            </div>
            
        </div>
    </div>
@endsection