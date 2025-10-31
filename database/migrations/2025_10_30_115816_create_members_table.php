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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_code')->unique(); // Kode member unik (contoh: MBR-20251030-XXXXX)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke user pelanggan
            $table->integer('total_points')->default(0); // Total poin saat ini
            $table->integer('lifetime_points')->default(0); // Total poin sepanjang waktu
            $table->date('joined_date'); // Tanggal bergabung
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
