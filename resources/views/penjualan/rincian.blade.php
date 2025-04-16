@extends('layouts.app')

@section('title', 'Rincian Penjualan')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-center">Produk yang dipilih</h4>

                    <form action="{{ route('penjualan.store') }}" method="POST" onsubmit="return validateForm()">
                        @csrf

                        <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">

                        <ul class="list-group mb-4">
                            @foreach ($produkDipilih as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item['nama_produk'] }}</strong><br>
                                        <span class="text-muted">{{ $item['jumlah'] }} x Rp
                                            {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                    </div>
                                    <span class="fw-bold text-muted">Rp
                                        {{ number_format($item['subtotal'], 0, ',', '.') }}</span>

                                    <input type="hidden" name="detail[{{ $loop->index }}][id_produk]"
                                        value="{{ $item['id'] }}">
                                    <input type="hidden" name="detail[{{ $loop->index }}][jumlah]"
                                        value="{{ $item['jumlah'] }}">
                                </li>
                            @endforeach
                        </ul>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Total Harga:</label>
                            <p class="fs-4 fw-bold text-muted" id="total-harga" data-total="{{ $totalHarga }}">
                                Rp {{ number_format($totalHarga, 0, ',', '.') }}
                            </p>
                        </div>
                        <input type="text" name="petugas" value="{{ session('user')->name }}" hidden>
                        <select name="member" id="member" class="form-select">
                            <option value="Bukan Member">Bukan Member</option>
                            <option value="Member">Member</option>
                        </select>
                        
                        <div id="phone-input-container" class="mb-3 d-none">
                            <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Masukkan nomor telepon">
                        </div>
                        
                        <div class="mb-3">
                            <label for="uang_diberi" class="form-label fw-semibold">Total bayar</label>
                            <input type="text" class="form-control" id="uang_diberi" required>
                            <input type="hidden" name="uang_diberi" id="uang_diberi_hidden">

                            <small id="error-message" class="text-danger d-none">Uang yang diberikan kurang dari total
                                harga.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const uangFormatted = document.getElementById('uang_diberi');
        const uangHidden = document.getElementById('uang_diberi_hidden');
        const errorMessage = document.getElementById('error-message');
        const total = parseInt(document.getElementById('total-harga').dataset.total);

        // Fungsi memformat input angka ke format IDR
        uangFormatted.addEventListener('input', function() {
            // Ambil angka mentah (tanpa titik, tanpa huruf)
            let raw = this.value.replace(/\D/g, '');

            // Simpan ke input hidden (biar dikirim ke server dalam format angka murni)
            uangHidden.value = raw;

            // Tampilkan ke input dengan format titik ribuan
            this.value = new Intl.NumberFormat('id-ID').format(raw);

            // Validasi apakah cukup untuk membayar
            const value = parseInt(raw) || 0;
            if (value < total) {
                errorMessage.classList.remove('d-none');
            } else {
                errorMessage.classList.add('d-none');
            }
        });

        // Fungsi validasi saat form disubmit
        function validateForm() {
            const value = parseInt(uangHidden.value) || 0;
            if (value < total) {
                errorMessage.classList.remove('d-none');
                return false; 
            }
            return true; 
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const memberSelect = document.getElementById('member');
    const phoneInputContainer = document.getElementById('phone-input-container');

    memberSelect.addEventListener('change', function () {
        if (this.value === 'Member') {
            phoneInputContainer.classList.remove('d-none'); // Tampilkan input nomor telepon
        } else {
            phoneInputContainer.classList.add('d-none'); // Sembunyikan input nomor telepon
        }
    });
});
    </script>

@endsection
