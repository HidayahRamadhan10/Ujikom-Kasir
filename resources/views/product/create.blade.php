@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Produk</h1>

        @if ($errors->any())
            <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-medium">Nama Produk <span class="text-red-600">*</span></label>
                <input type="text" name="nama_produk" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('nama_produk') }}" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Gambar Produk</label>
                <input type="file" name="img" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium">Harga <span class="text-red-600">*</span></label>
                    <input type="text" name="harga" id="harga" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('harga') }}" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Stok <span class="text-red-600">*</span></label>
                    <input type="number" name="stok" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('stok') }}" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg shadow-md transition duration-200">
                Simpan
            </button>
        </form>
    </div>
</div>

<script>
    // Format harga saat pengguna mengetik
    document.getElementById('harga').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, ''); // Menghapus karakter non-digit
        if (value.length > 0) {
            value = 'Rp. ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Menambahkan format ribuan
        }
        e.target.value = value;
    });

    // Bersihkan format sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const hargaInput = document.getElementById('harga');
        hargaInput.value = hargaInput.value.replace(/[^\d]/g, ''); // Bersihkan format
    });
</script>

@endsection