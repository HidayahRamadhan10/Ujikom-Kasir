<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembelian</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Struk Pembelian</h2>

    <p><strong>Nama Customer:</strong> {{ $pembelian->customer_name }}</p>
    <p><strong>Status Member:</strong> {{ $member ? 'Member' : 'Bukan Member' }}</p>
    @if($member)
        <p><strong>No. HP:</strong> {{ $member->phone_number }}</p>
        <p><strong>Poin:</strong> {{ $member->points }}</p>
        <p><strong>Member Sejak:</strong> {{ \Carbon\Carbon::parse($member->member_since)->translatedFormat('d F Y') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelian->details as $detail)
            <tr>
                <td>{{ $detail->product->nama_produk }}</td>
                <td style="text-align: center;">{{ $detail->quantity }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                <td style="text-align: right;">Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <br>
    <p>Dibuat pada: {{ $pembelian->created_at->format('Y-m-d H:i:s') }}</p>
    <p>Oleh: {{ $pembelian->dibuat_oleh }}</p>

</body>
</html>
