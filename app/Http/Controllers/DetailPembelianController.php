<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class DetailPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailPembelian $detailPembelian)
    {
        //
    }
    
    public function ajaxDetail($id)
    {
        $pembelian = Pembelian::with(['details.product'])->findOrFail($id);

        return response()->json([
            'details' => $pembelian->details->map(function ($detail) {
                return [
                    'produk' => $detail->product->nama_produk,
                    'jumlah' => $detail->quantity,
                    'total' => number_format($detail->total_price, 0, ',', '.')
                ];
            })
        ]);
    }

    public function ajaxDetailHTML($id)
    {
        $pembelian = Pembelian::with(['details.product', 'member'])->findOrFail($id);
        return view('pembelian.detail', compact('pembelian'));
    }

}