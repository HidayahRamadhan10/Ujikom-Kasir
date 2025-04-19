@extends('layouts.app')

@section('title', 'Informasi Member')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex flex-col md:flex-row md:gap-x-12">
                <!-- Daftar Produk -->
                <div class="md:w-1/2 mb-6 md:mb-0">
                    <h4 class="text-lg font-medium mb-4">Produk yang dipilih</h4>
                    @php
                        $selectedProducts = json_decode($products, true);
                    @endphp
                    @foreach($selectedProducts as $product)
                    <div class="flex justify-between mb-2">
                        <span>{{ $product['name'] }} x {{ $product['quantity'] }}</span>
                        <span>Rp. {{ number_format($product['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach

                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between">
                            <span class="font-medium">Total</span>
                            <span class="font-bold">Rp. {{ number_format($total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('pembelian.pembayaran') }}" method="POST" class="md:w-1/2">
                    @csrf
                    <input type="hidden" name="products" value="{{ $products }}">
                    <input type="hidden" name="total_amount" value="{{ $total_amount }}">
                    <input type="hidden" name="total_bayar" value="{{ $total_bayar }}">
                    <input type="hidden" name="phone_number" value="{{ $phone_number }}">
                    <input type="hidden" name="member_type" value="member">
                    <input type="hidden" name="points_to_use" value="{{ $existingPoints }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Member (identitas)</label>
                        <input type="text" name="member_name" class="w-full border rounded-md px-3 py-2" 
                            value="{{ $memberName }}" {{ $memberName ? '' : 'required' }}>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Poin</label>
                        <div class="bg-gray-100 p-2 rounded">
                            @php
                                $newPoints = floor($total_amount * 0.01);
                                $totalPoints = $existingPoints + $newPoints;
                            @endphp
                            <span>{{ $totalPoints }}</span>
                        </div>

                        @if($isNewMember)
                        <div class="mt-2 text-sm text-red-600 flex items-center">
                            <input type="checkbox" name="accept_points_future" class="mr-2" disabled>
                            <span>Poin tidak dapat digunakan pada pembelanjaan pertama</span>
                        </div>
                        @else
                        <div class="mt-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="use_points" class="mr-2">
                                <span>Gunakan poin</span>
                            </label>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md w-full">
                            Selanjutnya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection