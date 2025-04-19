<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $todaySales = Pembelian::whereDate('created_at', today())->count();
    
        // Data pembelian harian (7 hari terakhir)
        $dailySales = Pembelian::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
        // Data pembelian per produk
        $productSales = DB::table('detail_pembelians')
            ->join('products', 'detail_pembelians.product_id', '=', 'products.id')
            ->select('products.nama_produk', DB::raw('COUNT(*) as total'))
            ->groupBy('products.nama_produk')
            ->orderByDesc('total')
            ->get();

        return view('dashboard', compact(
            'role',
            'totalProducts', 
            'totalUsers', 
            'todaySales', 
            'dailySales', 
            'productSales'
        ));
    }
}