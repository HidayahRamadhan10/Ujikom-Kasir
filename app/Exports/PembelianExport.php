<?php

namespace App\Exports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PembelianExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pembelian::with('details')->get()->map(function ($item) {
            return [
                'ID'              => $item->id,
                'Nama Pelanggan'  => $item->customer_name,
                'Tanggal'         => $item->tanggal,
                'Total Harga'     => $item->grand_total,
                'Dibuat Oleh'     => $item->dibuat_oleh,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelanggan',
            'Tanggal',
            'Total Harga',
            'Dibuat Oleh'
        ];
    }
}
