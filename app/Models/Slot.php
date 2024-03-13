<?php

namespace App\Models;

use App\Casts\TimeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'barber_shop_id',
        'slot_date',
        'start_time',
        'end_time',
    ];

    protected function casts(): array
    {
        return [
            'slot_date' => 'date:Y-m-d',
            'start_time' => TimeCast::class,
            'end_time' => TimeCast::class,
        ];
    }

    public function barberShop(): BelongsTo
    {
        return $this->belongsTo(BarberShop::class);
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }

    public function canBeBooked(): bool
    {
        return $this->slot_date->isFuture() && !$this->isBooked();
    }

    public function isBooked(): bool
    {
        return !is_null($this->booking);
    }

    public function isMyBooking(): bool
    {
        return $this->booking?->isMyBooking(auth()->user()) ?? false;
    }

    public function canCancelBook(): bool
    {
        return $this->isBooked() && $this->booking->canBeCancelledByUser(auth()->user());
    }
}
