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
            $table->string('no_nota');
            $table->unsignedBigInteger('konsumen_id');
            $table->double('diskon');
            $table->double('harga_tambahan');
            $table->double('total');
            $table->timestamps();

            $table->foreign('konsumen_id')
                  ->references('id')
                  ->on('konsumens')
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
