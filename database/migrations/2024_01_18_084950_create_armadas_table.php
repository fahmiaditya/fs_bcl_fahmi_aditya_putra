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
        Schema::create('armadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_armada_id');
            $table->string('nomor')->unique();
            $table->integer('kapasitas')->default(0)->comment('satuan kg');
            $table->char('ketersediaan', 1)->default(1)->comment('0:tdk tersedia 1:tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armadas');
    }
};
