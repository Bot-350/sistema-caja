<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CashMovement extends Model
{
    protected $fillable = [
        'cash_register_id',
        'user_id',
        'type',
        'amount',
        'reason',
    ];

    protected static function booted(): void
    {
        static::saving(function (CashMovement $movement): void {
            if (filled($movement->reason)) {
                $movement->description = $movement->reason;
            }
        });
    }

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => match ($value) {
                'income' => 'ingreso',
                'expense' => 'egreso',
                default => $value,
            },
            set: fn ($value) => match ($value) {
                'ingreso' => 'income',
                'egreso' => 'expense',
                default => $value,
            },
        );
    }

    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
