<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
         Schema::create('produk', function (Blueprint $table) {
             $table->id();
             $table->string('gambar')->nullable(); 
             $table->string('nama_produk');
             $table->decimal('harga', 15, 2);
             $table->integer('stok');
             $table->timestamps();
         });
    }

    public function down()
    {
         Schema::dropIfExists('produks');
    }
}
