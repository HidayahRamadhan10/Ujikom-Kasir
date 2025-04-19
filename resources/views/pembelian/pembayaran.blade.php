@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container mx-auto px-4 py-4">
    <h3 class="text-xl font-semibold mb-4">Pembayaran</h3>

    <div class="bg-white shadow-md rounded-lg p-4">
        {{-- Informasi Member & Invoice --}}
        <div class="flex justify-between items-start mb-6">
            <div>
                @if(isset($member) && $member)
                <p class="text-sm text-gray-600">{{ $member->phone_number }}</p>
                <p class="text-sm text-gray-600">MEMBER SEJAK : {{ \Carbon\Carbon::parse($member->member_since)->translatedFormat('d F Y') }}</p>
                <p class="text-sm text-gray-600">MEMBER POIN : {{ number_format($member->points, 0, ',', '.') }}</p>
                @endif
            </div>
            <div class="text-right">
                <h4 class="text-base font-medium">Invoice - #{{ $invoice_number }}</h4>
                <p class="text-sm text-gray-600">{{ date('d F Y') }}</p>
            </div>
        </div>

        {{-- Tabel Produk --}}
        <table class="w-full mb-6">
            <thead>
                <tr class="text-left text-sm border-b">
                    <th class="pb-2">Produk</th>
                    <th class="pb-2">Harga</th>
                    <th class="pb-2">Qty</th>
                    <th class="pb-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach($selectedProducts as $product)
                <tr class="border-b">
                    <td class="py-2">{{ $product['name'] }}</td>
                    <td>Rp. {{ number_format($product['price'], 0, ',', '.') }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td class="text-right">Rp. {{ number_format($product['subtotal'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Info Pembayaran --}}
        <div class="flex flex-col md:flex-row rounded-lg overflow-hidden bg-gray-100 mt-6">
            {{-- Info Kiri --}}
            <div class="w-full md:w-3/4 p-4 flex flex-wrap gap-y-4">
                <div class="w-1/3">
                    <p class="text-xs uppercase text-gray-500 mb-1">Poin Digunakan</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $points_used ?? 0 }}</p>
                </div>
                <div class="w-1/3">
                    <p class="text-xs uppercase text-gray-500 mb-1">Kasir</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $pembelian->dibuat_oleh }}</p>
                </div>
                <div class="w-1/3">
                    <p class="text-xs uppercase text-gray-500 mb-1">Kembalian</p>
                    <p class="text-lg font-semibold text-gray-700">Rp. {{ number_format($kembalian, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Total Kanan --}}
            <div class="w-full md:w-1/4 bg-gray-800 text-white p-4 flex flex-col justify-center">
                <p class="text-xs uppercase text-gray-300">Total</p>
                @if($discount_from_points > 0)
                    <p class="line-through text-sm">Rp. {{ number_format($total, 0, ',', '.') }}</p>
                @endif
                <p class="text-2xl font-bold">Rp. {{ number_format($final_total, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex justify-end">
            <a href="{{ route('pembelian.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 mx-2 rounded-md text-sm">
                Kembali
            </a>
            <a href="{{ route('pembelian.export_pdf', $pembelian->id) }}" 
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md ml-2">
                Unduh Struk
             </a>             
        </div>
    </div>
</div>
@endsection