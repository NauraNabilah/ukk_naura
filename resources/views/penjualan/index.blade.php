@extends('layouts.app')

@section('title', 'Daftar Penjualan - Petugas')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold fs-4 mb-0">Daftar Penjualan </h1>
        @if (session('user.role') == 'petugas')
             <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
            + Tambah Transaksi
        </a>
        @endif
    </div>

    <div class="mb-4">
        <a class="btn btn-success" href="{{ route('penjualan.exportExcel') }}">
            Export Penjualan (.xls)
        </a>     
    </div>

    @if ($penjualans->isEmpty())
        <div class="alert alert-info text-center">Belum ada transaksi.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle bg-white">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Petugas</th>
                        <th>Tanggal Penjualan</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualans as $penjualan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $penjualan->member->name ?? 'Tidak Ada Member' }}</td>
                            <td>{{ $penjualan->petugas }}</td>
                            <td>{{ $penjualan->tanggal }}</td>
                            <td>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $penjualan->id }}">
                                    Detail
                                </a>
                                
                                <a href="{{ route('penjualan.unduh', $penjualan->id) }}" class="btn btn-sm btn-outline-success ms-2">
                                    Unduh Bukti
                                </a>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalDetail{{ $penjualan->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $penjualan->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel{{ $penjualan->id }}">Detail Penjualan #{{ $penjualan->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item"><strong>Tanggal:</strong> {{ $penjualan->tanggal }}</li>
                                            <li class="list-group-item"><strong>Petugas:</strong> {{ $penjualan->petugas }}</li>
                                            <li class="list-group-item"><strong>Member:</strong> {{ $penjualan->member->name ?? '-' }}</li>
                                            <li class="list-group-item"><strong>Total Harga:</strong> Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</li>
                                            <li class="list-group-item"><strong>Uang Diberi:</strong> Rp {{ number_format($penjualan->uang_diberi, 0, ',', '.') }}</li>
                                            <li class="list-group-item"><strong>Uang Kembali:</strong> Rp {{ number_format($penjualan->uang_kembali, 0, ',', '.') }}</li>
                                        </ul>

                                        <h6 class="fw-semibold">Produk Dibeli:</h6>
                                        <ul class="list-group">
                                            @foreach ($penjualan->detailPenjualan as $detail)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        {{ $detail->nama_produk }} <br>
                                                        <small class="text-muted">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</small>
                                                    </div>
                                                    <span class="fw-semibold">Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item {{ $penjualans->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $penjualans->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @foreach ($penjualans->getUrlRange(1, $penjualans->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $penjualans->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ $penjualans->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $penjualans->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    @endif
</div>
@endsection
