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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('merek');
            $table->string('model');
            $table->text('spesifikasi')->nullable();
            $table->string('warna')->nullable();
            $table->string('kondisi');
            $table->string('kelengkapan')->nullable();
            $table->decimal('harga', 12, 2);
            $table->unsignedInteger('stok')->default(1);
            $table->enum('status', ['Tersedia', 'Ditahan', 'Terjual'])->default('Tersedia');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
