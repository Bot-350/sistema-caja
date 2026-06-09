<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    protected $fillable = [
        'user_id',
        'opening_amount',
        'status',
        'opened_at',
        'closed_at'
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime'
    ];

    // Pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Obtener las ventas del turno
    public function sales()
    {
        return Sale::where('status', 'activa')
            ->where('created_at', '>=', $this->opened_at)
            ->when($this->closed_at, fn($q) => $q->where('created_at', '<=', $this->closed_at));
    }

    // Movimientos manuales de caja
    public function movements()
    {
        return $this->hasMany(CashMovement::class);
    }
}
