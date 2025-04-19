@extends('layouts.app')

@section('title', 'Product')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- After the title div -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Produk</h1>

        <!-- Tampilkan tombol "Tambah Produk" hanya jika role admin -->
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('product.create') }}" class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 shadow-md">
                <i class="fas fa-plus mr-2"></i>
                Tambah Produk
            </a>
        @endif
    </div>

    @if (session('success'))
        <div id="success-message" class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div id="error-message" class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if (session('info'))
        <div id="info-message" class="p-4 mb-6 text-sm text-blue-700 bg-blue-100 rounded-lg flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            {{ session('info') }}
        </div>
    @endif

    <script>
        // Auto-hide all alert messages after 3 seconds
        ['success-message', 'error-message', 'info-message'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                setTimeout(() => {
                    element.style.display = 'none';
                }, 4000);
            }
        });
    </script>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-sm text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">ID</th>
                    <th scope="col" class="px-6 py-3 text-center">Gambar</th>
                    <th scope="col" class="px-6 py-3 text-left">Nama Produk</th>
                    <th scope="col" class="px-6 py-3 text-left">Harga</th>
                    <th scope="col" class="px-6 py-3 text-center">Stok</th>
                    <!-- Aksi kolom hanya jika user adalah admin -->
                    @if(Auth::user()->role === 'admin')
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1; 
                @endphp

                @forelse ($products as $product)
                <tr class="bg-white border-b hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 text-center font-semibold text-gray-900">
                        {{ $counter++ }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center">
                            @if($product->img)
                                <img src="{{ asset('storage/' . $product->img) }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200" alt="{{ $product->nama_produk }}">
                            @else
                                <div class="w-16 h-16 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-xl"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $product->nama_produk }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span id="stock-{{ $product->id }}" class="px-3 py-1 rounded-full text-xs font-medium {{ $product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stok }} {{ $product->stok > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </td>
                    <!-- Aksi kolom hanya untuk admin -->
                    @if(Auth::user()->role === 'admin')
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('product.edit', ['product' => $product->id]) }}" class="text-blue-600 hover:text-blue-800 transition duration-200" title="Edit">
                                    <i class="fas fa-edit fa-lg"></i>
                                </a>
                                <button onclick="openModal({{ $product->id }}, '{{ $product->nama_produk }}', {{ $product->stok }})" class="text-green-600 hover:text-green-800 transition duration-200" title="Tambah Stok">
                                    <i class="fas fa-plus-circle fa-lg"></i>
                                </button>                            
                                <form action="{{ route('product.destroy', ['product' => $product->id]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition duration-200" title="Hapus" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash-alt fa-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    @endif
                </tr>
                @empty
                <tr class="bg-white">
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-box-open text-4xl text-gray-300 mb-2"></i>
                            <p class="text-gray-400">Belum ada data produk</p>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('product.create') }}" class="mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-plus mr-1"></i> Tambah Produk Pertama
                                </a>
                            @endif
                            
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Update Stok -->
    <div id="update-stock-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-96">
            <h2 class="text-xl font-semibold mb-4">Update Stok Produk</h2>
            <form id="update-stock-form" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="product_id" id="product_id">
    
                <!-- Menampilkan stok sebelumnya -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input id="product-name" class="text-sm text-gray-600 p-2 border border-gray-300 rounded-md w-full" readonly>
                </div>
    
                <!-- Input untuk stok baru -->
                <div class="mb-4">
                    <label for="new_stock" class="block text-sm font-medium text-gray-700">Jumlah Stok Baru</label>
                    <input type="number" name="new_stock" id="new_stock" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
    
                <div class="flex justify-between">
                    <button type="button" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md" onclick="closeModal()">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>    

</div>

<script>
    function openModal(productId, productName, stock) {
        document.getElementById('product_id').value = productId;
        document.getElementById('product-name').value = productName;
        document.getElementById('new_stock').value = stock;
        document.getElementById('update-stock-form').action = `/product/${productId}/update-stock`;
        document.getElementById('update-stock-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('update-stock-modal').classList.add('hidden');
    }
</script>

@endsection