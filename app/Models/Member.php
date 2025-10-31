<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    protected $fillable = [
        'member_code',
        'user_id',
        'total_points',
        'lifetime_points',
        'joined_date',
        'status',
    ];

    protected $casts = [
        'joined_date' => 'date',
    ];

    /**
     * Auto-generate member code saat membuat member baru
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($member) {
            if (empty($member->member_code)) {
                $member->member_code = 'MBR-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
            if (empty($member->joined_date)) {
                $member->joined_date = now();
            }
        });
    }

    /**
     * Relasi ke User (pelanggan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Member Points
     */
    public function points()
    {
        return $this->hasMany(MemberPoint::class);
    }

    /**
     * Relasi ke Member Vouchers
     */
    public function vouchers()
    {
        return $this->hasMany(MemberVoucher::class);
    }

    /**
     * Get voucher yang masih aktif
     */
    public function activeVouchers()
    {
        return $this->hasMany(MemberVoucher::class)
            ->where('status', 'active')
            ->where('expired_at', '>', now());
    }

    /**
     * Tambah poin dari transaksi
     * Aturan: Rp 10.000 = 1 poin
     */
    public function addPointsFromTransaction($transaction)
    {
        $pointsEarned = floor($transaction->total / 10000); // 1 poin per 10rb
        
        if ($pointsEarned > 0) {
            // Simpan history poin
            $this->points()->create([
                'transaction_id' => $transaction->id,
                'type' => 'earned',
                'points' => $pointsEarned,
                'description' => 'Belanja Rp ' . number_format($transaction->total, 0, ',', '.'),
                'expired_at' => now()->addYear(), // Poin berlaku 1 tahun
            ]);

            // Update total poin member
            $this->increment('total_points', $pointsEarned);
            $this->increment('lifetime_points', $pointsEarned);

            return $pointsEarned;
        }

        return 0;
    }

    /**
     * Kurangi poin (untuk redeem voucher/diskon)
     */
    public function redeemPoints($points, $description)
    {
        if ($this->total_points >= $points) {
            $this->points()->create([
                'type' => 'redeemed',
                'points' => -$points,
                'description' => $description,
            ]);

            $this->decrement('total_points', $points);

            return true;
        }

        return false;
    }

    /**
     * Cek apakah member masih aktif
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}

