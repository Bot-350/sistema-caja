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
        'total'
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
