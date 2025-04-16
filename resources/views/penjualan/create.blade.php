@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold fs-3 text-dark">Penjualan</h2>

    <form action="{{ route('penjualan.rincian') }}" method="POST">
        @csrf
        <div class="row g-4">
            @foreach ($produks as $produk)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="border rounded-4 shadow-sm p-3 text-center h-100">
                        <img src="{{ $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default.png') }}" 
                            class="mb-3 rounded"
                            alt="{{ $produk->nama_produk }}"
                            style="width: 80%; height: 180px; object-fit: cover; object-position: center;">

                        <h5 class="fw-semibold mb-1 text-capitalize">{{ $produk->nama_produk }}</h5>
                        <p class="text-muted mb-1 stok-text">Stok {{ $produk->stok }}</p>
                        <p class="text-primary fw-semibold mb-1">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                        <p class="text-muted mb-2" id="subtotal-text-{{ $produk->id }}">Subtotal: Rp 0</p>

                        <div class="d-flex justify-content-center align-items-center mb-2">
                            <button type="button" class="btn btn-light border rounded-circle px-3 decrement" 
                                onclick="decreaseQty({{ $produk->id }}, {{ $produk->harga }})"
                                aria-label="Kurangi jumlah produk">-</button>

                            <input type="number"
                                class="form-control mx-2 text-center produk-quantity text-dark fw-bold fs-5 shadow-sm"
                                id="qty-{{ $produk->id }}"
                                name="produks[{{ $produk->id }}]"
                                value="0"
                                min="0"
                                readonly
                                style="width: 60px; height: 45px;">

                            <button type="button" class="btn btn-light border rounded-circle px-3 increment"
                                onclick="increaseQty({{ $produk->id }}, {{ $produk->harga }})"
                                aria-label="Tambah jumlah produk">+</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="position-fixed bottom-0 start-50 translate-middle-x bg-white py-3 shadow-sm w-100">
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary px-5 py-2 rounded-pill" type="submit">
                    Selanjutnya
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
<script>
    function updateSubtotal(id, harga) {
        const qty = parseInt(document.getElementById('qty-' + id).value) || 0;
        const subtotal = harga * qty;
        const formatted = subtotal.toLocaleString('id-ID');
        document.getElementById('subtotal-text-' + id).innerText = 'Subtotal: Rp ' + formatted;
    }

    function decreaseQty(id, harga) {
        const qtyInput = document.getElementById('qty-' + id);
        let currentQty = parseInt(qtyInput.value) || 0;

        if (currentQty > 0) {
            qtyInput.value = currentQty - 1;
            updateSubtotal(id, harga);
        }
    }

    function increaseQty(id, harga) {
        const qtyInput = document.getElementById('qty-' + id);
        let currentQty = parseInt(qtyInput.value) || 0;

        qtyInput.value = currentQty + 1;
        updateSubtotal(id, harga);
    }
</script>
