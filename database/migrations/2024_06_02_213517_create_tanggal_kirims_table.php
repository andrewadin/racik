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
        Schema::create('tanggal_kirims', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('waktu_id');
            $table->unsignedBigInteger('menu_id');
            $table->date('tgl_kirim');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('pesanan_id')
                  ->references('id')
                  ->on('pesanans')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->foreign('waktu_id')
                  ->references('id')
                  ->on('waktu_kirims')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->foreign('menu_id')
                  ->references('id')
                  ->on('menu_pesanans')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggal_kirims');
    }
};
