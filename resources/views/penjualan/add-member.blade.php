@extends('layouts.app')

@section('title', 'Tambah Member')

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4 text-center">Tambah Member</h4>

                <form method="POST" action="{{ route('member.store') }}">
                    @csrf
                    <input type="hidden" name="sale_id" value="{{ $penjualan->id }}">

                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>Nama Produk</th>
                                            <th>QTY</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detailPenjualan as $detail)
                                            <tr>
                                                <td>{{ $detail->produk->nama_produk }}</td>
                                                <td>{{ $detail->jumlah }}</td>
                                                <td>Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                                <td>Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-light">
                                            <td colspan="2"></td>
                                            <td><strong>Total Harga</strong></td>
                                            <td><strong>Rp. {{ number_format($penjualan->total_harga, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr class="bg-light">
                                            <td colspan="2"></td>
                                            <td><strong>Total Bayar</strong></td>
                                            <td><strong>Rp. {{ number_format($penjualan->uang_diberi, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" id="phone" class="form-control" value="{{ $phone }}" disabled>
                                <input type="hidden" name="phone" value="{{ $phone }}">
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Member</label>
                                <input type="text" name="name" class="form-control" 
                                    value="{{ old('name', $existingMember->name ?? '') }}" 
                                    {{ $existing ? 'readonly' : '' }}>
                            </div>

                            <div class="mb-3">
                                <label for="poin" class="form-label">Poin </label>
                                @php
                                    $poinSebelumnya = $existingMember->poin ?? 0;
                                @endphp
                                <input type="text" id="poin" 
                                    value="{{ $poinSebelumnya }}" 
                                    disabled class="form-control">
                                <input type="hidden" name="poin" value="{{ $poinSebelumnya }}">
                            </div>

                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" value="Ya" id="check_poin" name="check_poin"
                                @if($existing && $existingMember && $existingMember->penjualans->count() >= 1)
                                        checked
                                    @else
                                        disabled
                                    @endif
                                >
                                <label class="form-check-label" for="check_poin">
                                    Gunakan poin untuk potongan harga
                                </label>

                                @if(!$existing || !$existingMember || $existingMember->penjualans->count() <= 1)
                                    <small class="text-danger d-block">Poin tidak dapat digunakan pada pembelanjaan pertama.</small>
                                @endif

                              

                            <div class="d-grid">
                                <button class="btn btn-primary" type="submit">Simpan Data Member</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection