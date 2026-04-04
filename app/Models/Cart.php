<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'coupon_id',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total cart amount based on items.
     */
    public function getTotalAmountAttribute()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->unit_price * $item->quantity;
        }
        return $total;
    }
}
