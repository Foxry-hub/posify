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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kasir yang melakukan transaksi
            $table->string('customer_name')->default('Umum'); // Nama pelanggan atau 'Umum'
            $table->string('customer_phone')->nullable(); // Nomor telepon pelanggan (optional)
            $table->decimal('subtotal', 15, 2)->default(0); // Total sebelum diskon
            $table->decimal('discount', 15, 2)->default(0); // Diskon (misal member discount)
            $table->decimal('tax', 15, 2)->default(0); // Pajak (PPN)
            $table->decimal('total', 15, 2)->default(0); // Total akhir
            $table->decimal('paid_amount', 15, 2)->default(0); // Jumlah yang dibayar
            $table->decimal('change', 15, 2)->default(0); // Kembalian
            $table->enum('payment_method', ['cash', 'debit', 'credit', 'qris'])->default('cash'); // Metode pembayaran
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
