@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Data Penjualan</h2>
        @if(Auth::user()->role === 'staf')
            <a href="{{ route('pembelian.create') }}" 
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>
                <span>Tambah Penjualan</span>
            </a>
        @endif
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 flex flex-wrap justify-between items-center border-b bg-gray-50 gap-4">
            <a href="{{ route('export-excel') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition">
                <i class="fas fa-file-excel mr-1"></i>Export Excel
            </a>            

            <div class="flex items-center space-x-2">
                <span class="text-gray-600">Tampilkan</span>
                <select id="per-page" class="border rounded-md px-3 py-2 bg-white">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-gray-600">entri</span>

                <span class="text-gray-600 ml-4">Cari:</span>
                <input type="text" id="search" class="border rounded-md px-3 py-2 w-full md:w-64" placeholder="Cari pembelian...">
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Dibuat Oleh</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pembelians as $index => $pembelian)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pembelian->customer_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pembelian->tanggal }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}</td>
                    {{-- <td>Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td> --}}
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pembelian->dibuat_oleh }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <a href="#" 
                           onclick="showDetail({{ $pembelian->id }})" 
                           class="inline-block text-yellow-500 hover:text-yellow-600  px-3 py-1 rounded transition mr-1">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data pembelian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pembelians->links() }}
    </div>
</div>

<script>
    function toggleDetail(id, btn) {
        fetch(`/pembelian/${id}/detail`)
            .then(response => response.text())
            .then(html => {
                // Create modal container
                const modal = document.createElement('div');
                modal.innerHTML = html;
                document.body.appendChild(modal);

                // Close modal when clicking outside
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        document.body.removeChild(modal);
                    }
                });
            });
    }
</script>

@endsection
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50"></div>

<script>
function showDetail(id) {
    const modal = document.getElementById('detailModal');
    modal.classList.remove('hidden');
    
    fetch(`/pembelian/detail/${id}`)
        .then(response => response.text())
        .then(html => {
            modal.innerHTML = html;
        });
}
</script>

<script>
    // Fungsi untuk menangani pencarian dan perubahan entri
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const perPageSelect = document.getElementById('per-page');
        let typingTimer;

        // Fungsi pencarian dengan debounce
        searchInput.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                const searchQuery = this.value;
                window.location.href = `{{ route('pembelian.index') }}?search=${searchQuery}&per_page=${perPageSelect.value}`;
            }, 500);
        });

        // Fungsi perubahan jumlah entri
        perPageSelect.addEventListener('change', function() {
            const searchQuery = searchInput.value;
            window.location.href = `{{ route('pembelian.index') }}?search=${searchQuery}&per_page=${this.value}`;
        });

        // Set nilai awal dari URL
        const urlParams = new URLSearchParams(window.location.search);
        searchInput.value = urlParams.get('search') || '';
        perPageSelect.value = urlParams.get('per_page') || '10';
    });
</script>

