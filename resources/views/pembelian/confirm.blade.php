@extends('layouts.app')

@section('title', 'Konfirmasi Penjualan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h3 class="text-2xl font-semibold mb-6">Penjualan</h3>
    
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-2 gap-6">
            <!-- Kolom Kiri - Informasi Produk -->
            <div>
                <h4 class="text-lg font-medium mb-4">Produk yang dipilih</h4>
                @foreach($selectedProducts as $product)
                <div class="flex items-center mb-2">
                    <div class="flex-1">
                        <p class="font-medium">{{ $product['name'] }}</p>
                        <p class="text-gray-600">Rp. {{ number_format($product['price'], 0, ',', '.') }} X {{ $product['quantity'] }}</p>
                    </div>
                    <div class="text-right">
                        <p>Rp. {{ number_format($product['subtotal'], 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach

                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg">Total</span>
                        <span class="text-lg font-bold">Rp. {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan - Form Pembayaran -->
            <div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Member Status</label>
                    <select id="memberType" name="member_type" class="w-full border rounded-md px-3 py-2">
                        <option value="non_member">Non Member</option>
                        <option value="member">Member</option>
                    </select>
                </div>

                <div id="memberFields" class="hidden">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">No Telepon</label>
                        <input type="text" name="phone_number" class="w-full border rounded-md px-3 py-2">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Bayar</label>
                    <input type="text" name="total_bayar" id="total_bayar" class="w-full border rounded-md px-3 py-2" 
                           placeholder="Rp. " oninput="validatePayment(this.value)">
                    <p id="payment_error" class="text-red-500 text-sm mt-1 hidden">Jumlah bayar kurang.</p>
                </div>

                <form action="{{ route('pembelian.member-info') }}" method="POST" id="payment_form">
                    @csrf
                    <input type="hidden" name="products" value="{{ json_encode($selectedProducts) }}">
                    <input type="hidden" name="total_amount" value="{{ $total }}">
                    <input type="hidden" name="member_type" id="hidden_member_type">
                    <input type="hidden" name="phone_number" id="hidden_phone_number">
                    <input type="hidden" name="total_bayar" id="hidden_total_bayar">
                    <div class="text-right">
                        <button type="submit" id="submit_btn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            Pesan
                        </button>
                    </div>
                </form>

@push('scripts')
<script>
    // Update form action based on member type
    document.addEventListener('DOMContentLoaded', function() {
        const memberType = document.getElementById('memberType');
        updateFormAction(memberType.value);
    });

    document.getElementById('memberType').addEventListener('change', function() {
        const memberFields = document.getElementById('memberFields');
        memberFields.classList.toggle('hidden', this.value === 'non_member');
        updateFormAction(this.value);
    });

    function updateFormAction(memberType) {
        const paymentForm = document.getElementById('payment_form');
        if (memberType === 'non_member') {
            paymentForm.action = "{{    route('pembelian.pembayaran') }}";
        } else {
            paymentForm.action = "{{ route('pembelian.member-info') }}";
        }
    }

    function formatRupiah(angka) {
        const number_string = angka.toString().replace(/[^,\d]/g, '');
        const split = number_string.split(',');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return 'Rp. ' + rupiah;
    }

    function validatePayment(value) {
        const cleanValue = parseInt(value.replace(/[^\d]/g, '')) || 0;
        const totalAmount = {{ $total }};
        const errorElement = document.getElementById('payment_error');
        const submitButton = document.getElementById('submit_btn');
        
        document.getElementById('total_bayar').value = formatRupiah(value);
        document.getElementById('hidden_total_bayar').value = cleanValue;

        if (cleanValue < totalAmount) {
            errorElement.classList.remove('hidden');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50');
        } else {
            errorElement.classList.add('hidden');
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50');
        }
    }

    document.getElementById('payment_form').addEventListener('submit', function(e) {
        e.preventDefault();
        const memberType = document.getElementById('memberType').value;
        const phoneNumber = document.querySelector('input[name="phone_number"]')?.value;
        const totalBayar = document.getElementById('total_bayar').value;

        document.getElementById('hidden_member_type').value = memberType;
        document.getElementById('hidden_phone_number').value = phoneNumber || '';
        document.getElementById('hidden_total_bayar').value = totalBayar.replace(/[^\d]/g, '');

        if (memberType === 'member' && !phoneNumber) {
            alert('Mohon isi nomor telepon untuk member');
            return;
        }

        if (!totalBayar) {
            alert('Mohon isi total bayar');
            return;
        }

        this.submit();
    });
</script>
@endpush
@endsection