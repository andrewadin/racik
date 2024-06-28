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
        Schema::create('menu_pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('paket_id');
            $table->double('harga');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('pesanan_id')
                  ->references('id')
                  ->on('pesanans')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('paket_id')
                  ->references('id')
                  ->on('pakets')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_pesanans');
    }
};
