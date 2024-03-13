<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\BarberShop;
use Illuminate\View\View;

class ListAvailableBarberShopsController extends Controller
{
    public function __invoke(): View
    {
        $barberShops = BarberShop::with('schedules')->get();
        return view('barber-shops.list', compact('barberShops'));
    }
}
