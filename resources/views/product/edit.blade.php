@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk</h1>

        @if ($errors->any())
            <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
        
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nama Produk <span class="text-red-600">*</span></label>
                    <input type="text" name="nama_produk" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                </div>
        
                <div>
                    <label class="block text-gray-700 font-medium">Gambar Produk</label>
                    <input type="file" name="img" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>
        
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium">Harga <span class="text-red-600">*</span></label>
                    <input type="text" name="harga" id="harga" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                    value="{{ old('harga', $product->harga ? 'Rp. ' . number_format($product->harga, 0, ',', '.') : '') }}" required>
                </div>
        
                <div>
                    <label class="block text-gray-700 font-medium">Stok</label>
                    <input type="text" class="w-full px-4 py-2 border bg-gray-100 rounded-lg text-gray-600" value="{{ $product->stok }} Tersedia" readonly>
                </div>
            </div>
        
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg shadow-md transition duration-200">
                Simpan Perubahan
            </button>
        </form>
        
    </div>
</div>

<script>
    // Format harga saat menampilkan
    document.addEventListener('DOMContentLoaded', function() {
        const hargaInput = document.getElementById('harga');
        let numericValue = hargaInput.value.replace(/[^\d]/g, '');
        if (numericValue.length > 0) {
            hargaInput.value = 'Rp. ' + parseInt(numericValue).toLocaleString('id-ID');
        }
    });

    // Format harga saat pengguna mengetik
    document.getElementById('harga').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        if (value.length > 0) {
            value = 'Rp. ' + parseInt(value).toLocaleString('id-ID');
        }
        e.target.value = value;
    });

    // Bersihkan format sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const hargaInput = document.getElementById('harga');
        hargaInput.value = hargaInput.value.replace(/[^\d]/g, '');
    });
</script>


@endsection