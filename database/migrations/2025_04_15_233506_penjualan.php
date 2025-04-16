<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_member')->nullable()->constrained('members')->onDelete('cascade');
            $table->date('tanggal');
            $table->bigInteger('total_harga');
            $table->string('petugas');
            $table->bigInteger('uang_diberi')->nullable();
            $table->bigInteger('uang_kembali')->nullable();
            $table->integer('point_used')->default(0);     
            $table->integer('point_earned')->default(0);   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
