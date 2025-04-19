<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('customer_name');
            $table->decimal('grand_total', 10, 2);
            $table->date('tanggal');
            $table->string('dibuat_oleh');
            $table->timestamps();
        });

        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('pembelians')->onDelete('cascade');
            $table->unsignedBigInteger('id_produk');
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();

            $table->foreign('id_produk')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelian_details');
        Schema::dropIfExists('pembelians');
    }

};