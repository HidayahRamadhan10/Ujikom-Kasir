<?php

use App\Exports\PembelianExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\DetailPembelianController;
use Maatwebsite\Excel\Facades\Excel;





// Basic routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login',function () {
    return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'login'])->name('login.post');
    Route::post('/logout', action: [UserController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class);

});

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::patch('/product/{product}/update-stock', [ProductController::class, 'updateStock'])->name('product.update-stock');

Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::get('/pembelian/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('/pembelian/{pembelian}', [PembelianController::class, 'show'])->name('pembelian.show');
    Route::post('/pembelian/confirm', [PembelianController::class, 'confirm'])->name('pembelian.confirm');
    Route::post('/pembelian/member-info', [PembelianController::class, 'memberInfo'])->name('pembelian.member-info');
    Route::post('/pembelian/non-member/pembayaran', [PembelianController::class, 'pembayaranNonMember'])->name('pembelian.non-member.pembayaran');
    Route::post('/pembelian/pembayaran', [PembelianController::class, 'pembayaran'])->name('pembelian.pembayaran');
    Route::get('/check-member/{phone}', [PembelianController::class, 'checkMember']);
    Route::get('/pembelian/detail/{pembelian}', [PembelianController::class, 'detail'])->name('pembelian.detail');
    Route::get('/pembelian/{id}/export-pdf', [PembelianController::class, 'exportPDF'])->name('pembelian.export_pdf');
    Route::get('/export-excel', function () {
        return Excel::download(new PembelianExport, 'data-pembelian.xlsx');
        })->name('export-excel');


     Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::get('/pembelian/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('/pembelian/{pembelian}', [PembelianController::class, 'show'])->name('pembelian.show');
    Route::post('/pembelian/confirm', [PembelianController::class, 'confirm'])->name('pembelian.confirm');

    Route::get('/pembelian/{id}/detail-html', [DetailPembelianController::class, 'ajaxDetailHTML']);

    // Route::get('generate-pdf', [PdfController::class, 'generatePdf']);
    // Route::get('export-excel', [ExcelController::class, 'exportExcel']);



    




