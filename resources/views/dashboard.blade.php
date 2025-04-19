@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white overflow-hidden shadow rounded-lg p-6">
        
        {{-- Jika Admin --}}
        @if ($role === 'admin')
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Selamat Datang, Administrator!</h1>

            <div class="flex flex-wrap gap-8 mb-8">
                <!-- Left side - Bar Chart -->
                <div class="flex-1 min-w-[400px]">
                    <h2 class="text-xl font-semibold text-gray-800 mb-8">Jumlah Pembelian</h2>
                    <div class="w-full">
                        <canvas id="barChart" height="300"></canvas>
                    </div>
                </div>

        {{-- Jika Staff --}}
        @elseif ($role === 'staf')
        <div class="container mx-auto px-4 py-6">
            <div class="space-y-4">
                <h1 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ Auth::user()->role === 'admin' ? 'Administrator!' : 'Petugas!' }}</h1>
                
                @if ($role === 'admin')
                    <!-- Charts Container -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                        <!-- Bar Chart -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-4">Jumlah Penjualan</h2>
                            <div style="height: 400px;">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-4">Persentase Penjualan Produk</h2>
                            <div style="height: 400px;">
                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Other dashboard content -->
                <div class="bg-white p-6 rounded-lg">
                    <div class="text-center space-y-3">
                        <h2 class="text-lg text-gray-800">Total Penjualan Hari Ini</h2>
                        <div class="text-5xl font-bold text-gray-900">
                            {{ $todaySales }}
                        </div>
                        <p class="text-gray-600">Jumlah total penjualan yang terjadi hari ini.</p>
                        <p class="text-sm text-gray-500">
                            Terakhir diperbarui: {{ now()->format('d F Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>

    {{-- Script hanya dijalankan jika Admin --}}
    @if ($role === 'admin')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Bar Chart - Jumlah Pembelian
                const barCtx = document.getElementById('barChart').getContext('2d');
                const dailySalesData = @json($dailySales);
                
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: dailySalesData.map(item => moment(item.date).format('DD MMM YYYY')),
                        datasets: [{
                            label: 'Jumlah Pembelian',
                            data: dailySalesData.map(item => item.total),
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 5
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endsection