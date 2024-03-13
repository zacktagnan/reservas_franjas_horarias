<?php

namespace App\Http\Controllers\Booking;

use Illuminate\View\View;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserBookingsController extends Controller
{
    // public function __invoke(Request $request): View
    public function __invoke(): View
    {
        // $bookings = auth()->user()->bookings();
        // $bookings_sql = $bookings->toSql();
        // $foo->get();
        // dd($bookings_sql);
        // $bookings = auth()->user()->bookings()->with('slot')->get();
        // $bookings = auth()->user()->bookings()->with('slot.barberShop')->get();

        // $bookings = auth()->user()->bookings()->with('slot.barberShop')->get();
        // $bookings = auth()->user()->bookings()->with('slot.barberShop');
        // $bookings_sql = $bookings->toSql();
        // dd($bookings_sql);

        $bookings = auth()->user()->bookings()->with('slot.barberShop')->get();

        return view('user.bookings', compact('bookings'));
    }
}
