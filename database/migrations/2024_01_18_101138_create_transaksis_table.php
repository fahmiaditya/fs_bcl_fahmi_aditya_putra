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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('armada_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('kode')->unique();
            $table->string('lokasi_asal');
            $table->string('lokasi_tujuan');
            $table->bigInteger('ttl_muatan')->default(0);
            $table->dateTime('tgl_pemesanan');
            $table->text('lokasi_update')->nullable();
            $table->dateTime('tgl_pengiriman')->nullable();
            $table->dateTime('tgl_tiba')->nullable();
            $table->char('status_pengiriman', 1)->default(0)->comment('0:tertunda 1:dalam perjalanan 2:telah tiba');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('armada_id')->references('id')
                ->on('armadas')
                ->onUpdate('cascade');

            $table->foreign('customer_id')->references('id')
                ->on('customers')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
