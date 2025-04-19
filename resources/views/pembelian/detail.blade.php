<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Detail Penjualan</h2>
            <a href="{{ route('pembelian.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <div class="mb-4">
            @php
                $member = \App\Models\Member::where('name', $pembelian->customer_name)->first();
            @endphp
            
            @if($member)
                <p class="text-gray-600">Member Status : Member</p>
                <p class="text-gray-600">No. HP : {{ $member->phone_number }}</p>
                <p class="text-gray-600">Poin Member : {{ $member->points }}</p>
                {{-- <p class="text-gray-600">Bergabung Sejak : {{ $member->member_since->format('d F Y') }}</p> --}}
                <p class="text-sm text-gray-600">MEMBER SEJAK : {{ \Carbon\Carbon::parse($member->member_since)->translatedFormat('d F Y') }}</p>
            @else
                <p class="text-gray-600">Member Status : Bukan Member</p>
                <p class="text-gray-600">No. HP : -</p>
                <p class="text-gray-600">Poin Member : -</p>
                <p class="text-gray-600">Bergabung Sejak : -</p>
            @endif
        </div>

        <div class="border-t border-b py-4 my-4">
            <table class="w-full">
                <thead>
                    <tr class="text-gray-600">
                        <th class="text-left">Nama Produk</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelian->details as $detail)
                    <tr>
                        <td class="py-2">{{ $detail->product->nama_produk }}</td>
                        <td class="text-center">{{ $detail->quantity }}</td>
                        <td class="text-right">Rp. {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                        <td class="text-right">Rp. {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-bold">
                        <td colspan="3" class="text-right pt-4">Total</td>
                        <td class="text-right pt-4">Rp. {{ number_format($pembelian->grand_total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-gray-600 text-sm">
            <p>Dibuat pada: {{ $pembelian->created_at->format('Y-m-d H:i:s') }}</p>
            <p>Oleh: {{ $pembelian->dibuat_oleh }}</p>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('pembelian.index') }}" 
               class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                Tutup
            </a>
        </div>
    </div>
</div>