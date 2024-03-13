<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'slot_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }

    public function barberShop(): HasOneThrough
    {
        // return $this->hasOneThrough(BarberShop::class, Slot::class, 'slot_id', 'barber_shop_id', 'id', 'id');
        return $this->hasOneThrough(BarberShop::class, Slot::class);
    }

    public function canBeCancelledByUser(User $user): bool
    {
        return $this->slot->slot_date->isFuture() && $this->isMyBooking($user);
    }

    public function isMyBooking(User $user): bool
    {
        return $this->user_id === $user->id;
    }
}
