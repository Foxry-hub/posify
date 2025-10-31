<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'user_id',
        'customer_id',
        'customer_name',
        'customer_phone',
        'subtotal',
        'discount',
        'tax',
        'total',
        'paid_amount',
        'change',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'change' => 'decimal:2',
    ];

    /**
     * Boot method untuk auto-generate transaction code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->transaction_code)) {
                $transaction->transaction_code = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Relasi ke User (Kasir)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Customer (Pelanggan)
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Relasi ke Transaction Items
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Calculate subtotal from items
     */
    public function calculateSubtotal()
    {
        return $this->items()->sum('subtotal');
    }

    /**
     * Calculate total with discount and tax
     */
    public function calculateTotal()
    {
        $subtotal = $this->subtotal;
        $afterDiscount = $subtotal - $this->discount;
        $total = $afterDiscount + $this->tax;
        
        return $total;
    }

    /**
     * Calculate change
     */
    public function calculateChange()
    {
        return $this->paid_amount - $this->total;
    }
}
