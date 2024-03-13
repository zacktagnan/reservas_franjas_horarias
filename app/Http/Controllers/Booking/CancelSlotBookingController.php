<?php

namespace App\Http\Controllers\Booking;

use App\Models\Booking;
use App\Models\BarberShop;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CancelSlotBookingController extends Controller
{
    public function __invoke(BarberShop $barberShop, Booking $booking): RedirectResponse
    {
        abort_if(
            $booking->trashed(),
            Response::HTTP_FORBIDDEN,
            __('¡Esta RESERVA ya está cancelada!'),
        );

        try {
            DB::beginTransaction();

            $booking->delete();

            /** @disregard P1013 ...To IGNORE -> Undefined method 'increment'.intelephense(P1013) */
            auth()->user()->increment('credit');

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
        }

        return redirect()->route('slots.show', [
            'barberShop' => $barberShop,
            'year' => $booking->slot->slot_date->year,
            'month' => $booking->slot->slot_date->month,
            'day' => $booking->slot->slot_date->day,
        ]);
    }
}
