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
        Schema::create('member_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('voucher_code')->unique(); // Kode unik voucher
            $table->string('voucher_type'); // discount_5, discount_10, cashback_10k, dll
            $table->string('voucher_name'); // Nama voucher
            $table->string('discount_type'); // percentage atau fixed
            $table->decimal('discount_value', 15, 2); // Nilai diskon (5, 10, 10000, dll)
            $table->decimal('min_purchase', 15, 2)->default(0); // Minimal pembelian
            $table->integer('points_used'); // Poin yang digunakan untuk redeem
            $table->enum('status', ['active', 'used', 'expired'])->default('active');
            $table->timestamp('used_at')->nullable(); // Kapan digunakan
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('set null'); // Transaksi yang menggunakan voucher
            $table->timestamp('expired_at'); // Voucher berlaku sampai kapan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_vouchers');
    }
};
