<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'harga' => str_replace(['Rp.', '.', ' '], '', $request->input('harga'))
        ]);
    
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        try {
            if ($request->hasFile('img')) {
                $imagePath = $request->file('img')->store('images', 'public');
                $validated['img'] = $imagePath;
            }
    
            Product::create($validated);
    
            return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => 'Gagal menyimpan produk: ' . $e->getMessage()
            ]);
        }
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->merge([
            'harga' => str_replace(['Rp.', '.', ' '], '', $request->input('harga'))
        ]);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        if ($request->hasFile('img')) {
            if ($product->img) {
                Storage::disk('public')->delete($product->img);
            }
            $validated['img'] = $request->file('img')->store('images', 'public');
        }
    
        $product->update($validated);
    
        return redirect()->route('product.index')
                        ->with('success', 'Produk berhasil diperbarui!');
    }
    

    public function updateStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'new_stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if ($product->stok == $request->new_stock) {
            return redirect()->route('product.index')
                ->with('info', 'Tidak ada perubahan pada stok produk.');
        }

        try {
            $product->stok = $request->new_stock;
            $product->save();
            return redirect()->route('product.index')
                ->with('success', 'Stok produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('product.index')
                ->with('error', 'Gagal memperbarui stok: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated image if exists
        if ($product->img) {
            Storage::disk('public')->delete($product->img);
        }

        $product->delete();

        return redirect()->route('product.index')
                        ->with('success', 'Product deleted successfully');
    }
}