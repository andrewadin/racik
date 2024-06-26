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
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->unsignedBigInteger('tipe_id');
            $table->double('harga');
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('tipe_id')
                  ->references('id')
                  ->on('tipe_pakets')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
