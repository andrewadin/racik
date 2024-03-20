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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('konsumen_id');
            $table->unsignedBigInteger('paket_id');
            $table->Integer('jumlah');
            $table->double('total');
            $table->string('catatan');
            $table->timestamps();

            $table->foreign('konsumen_id')
                  ->references('id')
                  ->on('konsumens')
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
        Schema::dropIfExists('pesanans');
    }
};
