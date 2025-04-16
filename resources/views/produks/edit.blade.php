@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('produks.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_produk" class="form-label fw-semibold text-dark">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" 
                        value="{{ old('nama_produk', $produk->nama_produk) }}" 
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label fw-semibold text-dark">Harga</label>
                    <input type="number" name="harga" id="harga" step="0.01" 
                        value="{{ old('harga', $produk->harga) }}" 
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label fw-semibold text-dark">Stok</label>
                    <input type="number" name="stok" id="stok" 
                        value="{{ old('stok', $produk->stok) }}" 
                        class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Gambar</label>
                    @if($produk->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" 
                                 alt="{{ $produk->nama_produk }}" 
                                 class="img-thumbnail" style="max-width: 150px; height: auto;">
                        </div>
                    @else
                        <p class="text-muted">Tidak ada gambar</p>
                    @endif
                    <input type="file" name="gambar" id="gambar" class="form-control mt-2">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-sm px-4">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
