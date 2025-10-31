<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberPoint extends Model
{
    protected $fillable = [
        'member_id',
        'transaction_id',
        'type',
        'points',
        'description',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'date',
    ];

    /**
     * Relasi ke Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Relasi ke Transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}

