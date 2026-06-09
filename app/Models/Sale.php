<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'number',
        'customer_id',
        'user_id',
        'user_name',
        'payment_method',
        'status',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'total'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
     return $this->hasMany(SaleItem::class);   
    }
}
