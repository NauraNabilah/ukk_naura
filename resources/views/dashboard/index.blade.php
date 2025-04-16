@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
    @php
    $labelProduk = $produkTerjual->pluck('nama');
    $jumlahProduk = $produkTerjual->pluck('jumlah');
    @endphp

    <div class="bg-white shadow rounded p-6 mb-4">
        <h1 class="text-3xl font-bold mb-4">Selamat Datang, {{ session('user.name') }}!</h1>
    </div>
@if (session('user.role') == 'petugas')
<div class="card border-0 rounded-4 overflow-hidden mb-4">
    <div class="bg-light text-center py-2">
        <strong class="text-secondary">Total Penjualan Hari Ini</strong>
    </div>

    <div class="text-center py-4">
        <h1 class="fw-bold text-dark mb-2">{{ $jmlTrans }}</h1>
        <p class="text-muted m-0">Jumlah total penjualan yang terjadi hari ini.</p>
    </div>

    <div class="bg-light text-center py-2">
        <small class="text-muted">Terakhir diperbarui: {{ now()->format('d M Y H:i') }}</small>
    </div>
</div>
@endif
    @if (session('user.role') == 'admin')
    <div style="width: 100%; background-color: white; " class="d-flex">
      
        <div class="" style="width:70%; height: 100%; ">
            <h5 class="mb-3 text-center">Statistik Penjualan</h5>
            <div class="d-flex justify-content-center">
                <canvas id="barChart"
                data-labels='@json($transaksiHarian->pluck("tanggal"))'
                data-values='@json($transaksiHarian->pluck("jumlah"))'>
            </canvas>
            </div>
        </div>

        <div class="" style="width:30%; ">
            <h5 class="mb-3 text-center">Statistik Penjualan</h5>
            <div class="d-flex justify-content-center">
                <canvas id="penjualanChart" ></canvas>
            </div>
        </div>
    </div>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const barCanvas = document.getElementById('barChart');

        if (barCanvas) {
            const labels = JSON.parse(barCanvas.dataset.labels);
            const values = JSON.parse(barCanvas.dataset.values);

            const ctx = barCanvas.getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: values,
                        backgroundColor: 'rgba(78, 115, 223, 0.6)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        barPercentage: 0.6,
                        categoryPercentage: 0.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0 
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return ` ${context.dataset.label}: ${context.parsed.y}`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pieCanvas = document.getElementById('penjualanChart');

        if (pieCanvas) {
            new Chart(pieCanvas, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($labelProduk) !!},
                    datasets: [{
                        data: {!! json_encode($jumlahProduk) !!},
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>


