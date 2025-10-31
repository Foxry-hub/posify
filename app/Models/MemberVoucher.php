<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MemberVoucher extends Model
{
    protected $fillable = [
        'member_id',
        'voucher_code',
        'voucher_type',
        'voucher_name',
        'discount_type',
        'discount_value',
        'min_purchase',
        'points_used',
        'status',
        'used_at',
        'transaction_id',
        'expired_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    /**
     * Boot method untuk generate voucher code otomatis
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($voucher) {
            if (empty($voucher->voucher_code)) {
                $voucher->voucher_code = 'VCR-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Relasi ke Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Relasi ke Transaction (jika sudah digunakan)
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Cek apakah voucher masih aktif
     */
    public function isActive()
    {
        return $this->status === 'active' 
            && $this->expired_at > now();
    }

    /**
     * Cek apakah voucher bisa digunakan untuk transaksi
     */
    public function canUseFor($transactionTotal)
    {
        return $this->isActive() 
            && $transactionTotal >= $this->min_purchase;
    }

    /**
     * Hitung nilai diskon untuk transaksi
     */
    public function calculateDiscount($transactionTotal)
    {
        if (!$this->canUseFor($transactionTotal)) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            return ($transactionTotal * $this->discount_value) / 100;
        } else {
            // fixed amount
            return $this->discount_value;
        }
    }

    /**
     * Gunakan voucher untuk transaksi
     */
    public function use($transactionId)
    {
        $this->status = 'used';
        $this->used_at = now();
        $this->transaction_id = $transactionId;
        $this->save();
    }
}

