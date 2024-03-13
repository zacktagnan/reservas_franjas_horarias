<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\BarberShop;
use Illuminate\View\View;

class ShowBarberShopSlotsController extends Controller
{
    public function __invoke(BarberShop $barberShop, int $year, int $month, int $day): View
    {
        $date = now()->setDate($year, $month, $day);

        $barberShop->load(['slots' => function ($query) use ($date) {
            $query->with('booking')->where('slot_date', $date->format('Y-m-d'));
        }]);

        return view('barber-shops.slots', compact('barberShop', 'date'));
    }
}
