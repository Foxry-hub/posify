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
        Schema::create('member_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade'); // Relasi ke members
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('set null'); // Relasi ke transaction (jika dari belanja)
            $table->enum('type', ['earned', 'redeemed', 'expired', 'adjusted'])->default('earned'); // Jenis poin
            $table->integer('points'); // Jumlah poin (positif untuk earned, negatif untuk redeemed)
            $table->text('description')->nullable(); // Deskripsi (contoh: "Belanja Rp 50.000" atau "Tukar voucher diskon 10%")
            $table->date('expired_at')->nullable(); // Tanggal kadaluarsa poin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_points');
    }
};
