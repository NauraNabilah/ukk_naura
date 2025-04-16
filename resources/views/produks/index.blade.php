@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 fw-bold text-black">Daftar Produk</h1>
            @if (session('user.role') == 'admin')
                <a href="{{ route('produks.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Tambah Produk
                </a>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0 align-middle">
                        <thead class="table-light text-center small">
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th class="text-start">Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                @if (session('user.role') == 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produks as $produk)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration + ($produks->currentPage() - 1) * $produks->perPage() }}</td>
                                    <td class="text-center">
                                        @if ($produk->gambar)
                                            <img src="{{ asset('storage/' . $produk->gambar) }}"
                                                alt="{{ $produk->nama_produk }}" class="rounded"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-start">{{ $produk->nama_produk }}</td>
                                    <td class="text-center">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $produk->stok }}</td>
                                    <td class="text-center">

                                        @if (session('user.role') == 'admin')
                                            <div class="d-flex justify-content-center gap-1 flex-wrap">
                                                <a href="{{ route('produks.edit', $produk->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('produks.destroy', $produk->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin hapus produk?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-info btn-sm text-white"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalUpdateStock-{{ $produk->id }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                                   <!-- Update Stok Button with Logo -->
                                    {{-- <a href="{{ route('produks.updateStock', $user->id) }}" class="btn btn-info btn-sm">
                                        <img src="{{ asset('assets/images/logo-update-stok.png') }}" alt="Logo Update Stok" width="16" class="me-1">
                                        Update Stok
                                    </a> --}}
                                            </div>
                                        @endif

                                    </td>
                                </tr>

                                <div class="modal fade" id="modalUpdateStock-{{ $produk->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <form action="{{ route('produks.updateStock', $produk->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Stok</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-2 small">Produk:
                                                        <strong>{{ $produk->nama_produk }}</strong></div>
                                                    <input type="number" name="stok" class="form-control"
                                                        value="{{ $produk->stok }}" required>
                                                </div>
                                                <div class="modal-footer p-2">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $produks->links() }}
        </div>
    </div>
@endsection
