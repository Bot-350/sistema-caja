<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'birthday',
        'visit_count'
    ];

    protected $casts = [
        'birthday' => 'date'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);    
    }
}
