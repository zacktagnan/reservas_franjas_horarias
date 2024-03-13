<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class BarberShop extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'image',
        'max_future_days',
        'slot_duration',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'phone' => 'string',
            'address' => 'string',
            'image' => 'string',
            'max_future_days' => 'int',
            'slot_duration' => 'int',
        ];
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    public function bookings(): HasManyThrough
    {
        // return $this->hasManyThrough(Booking::class, Slot::class, 'barber_shop_id', 'slot_id', 'id', 'id');
        return $this->hasManyThrough(Booking::class, Slot::class);
    }
}
