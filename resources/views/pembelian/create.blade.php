@extends('layouts.app')

@section('title', 'Tambah Penjualan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Tambah Penjualan Baru</h2>
        <a href="{{ route('pembelian.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form action="{{ route('pembelian.confirm') }}" method="POST" class="p-6" id="purchaseForm">
            @csrf
            {{-- <input type="hidden" name="phone_number" id="member_phone" value=""> --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="rounded-lg shadow-lg overflow-hidden bg-white p-4 text-center">
                        <img src="{{ asset('storage/' . $product->img) }}" class="w-full h-48 object-cover">
                        <h3 class="font-semibold text-gray-800 mt-2">{{ $product->nama_produk }}</h3>
                        <p class="text-gray-500">Stok: {{ $product->stok }}</p>
                        <p class="font-bold text-gray-800 my-2" data-price="{{ $product->harga }}">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </p>
                        <div class="flex items-center justify-center gap-4 mt-2">
                            <button type="button" class="px-3 py-1 bg-gray-200 rounded-md minus-btn">-</button>
                            <input type="number" name="quantities[{{ $product->id }}]" 
                                   value="0" min="0" max="{{ $product->stok }}"
                                   class="w-16 text-center quantity-input" readonly>
                            <button type="button" class="px-3 py-1 bg-gray-200 rounded-md plus-btn">+</button>
                        </div>
                        <p class="mt-2 text-sm text-gray-700">Sub Total: <strong class="subtotal">Rp 0</strong></p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md transition duration-200">
                    Selanjutnya
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const products = document.querySelectorAll('.rounded-lg.shadow-lg');
    
    products.forEach(product => {
        const minusBtn = product.querySelector('.minus-btn');
        const plusBtn = product.querySelector('.plus-btn');
        const quantityInput = product.querySelector('.quantity-input');
        const subtotalElement = product.querySelector('.subtotal');
        const price = parseInt(product.querySelector('[data-price]').dataset.price);
        
        function updateSubtotal() {
            const quantity = parseInt(quantityInput.value);
            const subtotal = price * quantity;
            subtotalElement.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        }
        
        minusBtn.addEventListener('click', () => {
            if (parseInt(quantityInput.value) > 0) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updateSubtotal();
            }
        });
        
        plusBtn.addEventListener('click', () => {
            if (parseInt(quantityInput.value) < parseInt(quantityInput.max)) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateSubtotal();
            }
        });
    });
});
</script>
@endpush
@endsection