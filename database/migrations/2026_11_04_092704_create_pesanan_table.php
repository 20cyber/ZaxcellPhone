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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_pembeli')->constrained('pembeli', 'id_pembeli')->restrictOnDelete();
            $table->foreignId('id_admin')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('total', 12, 2);
            $table->enum('status_pesanan', [
                'Menunggu Pembayaran',
                'Dibayar',
                'Diproses',
                'Dikirim',
                'Selesai',
                'Dibatalkan',
            ])->default('Menunggu Pembayaran');
            $table->dateTime('batas_bayar');
            $table->string('nomor_resi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
