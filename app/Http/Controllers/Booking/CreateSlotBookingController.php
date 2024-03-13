<?php

namespace App\Http\Controllers\Booking;

use App\Models\Slot;
use App\Models\BarberShop;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateSlotBookingController extends Controller
{
    // Recuperando al User por el Request...
    // public function __invoke(Request $request, BarberShop $barberShop, Slot $slot): RedirectResponse
    // Recuperando al User por el AUTH...
    public function __invoke(BarberShop $barberShop, Slot $slot): RedirectResponse
    {
        abort_if(
            // !$request->user()->hasCredits(),
            !auth()->user()->hasCredits(),
            Response::HTTP_FORBIDDEN,
            __('¡No tienes suficientes CRÉDITOS para realizar la reserva!'),
        );

        try {
            DB::beginTransaction();

            $slot->booking()->create([
                'user_id' => auth()->id(),
            ]);

            /** @disregard P1013 ...To IGNORE -> Undefined method 'decrement'.intelephense(P1013) */
            auth()->user()->decrement('credit');

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
        }

        return redirect()->route('slots.show', [
            // Tanto vale esto...
            // 'barberShop' => $slot->barberShop,
            // como esto otro...
            'barberShop' => $barberShop,
            'year' => $slot->slot_date->year,
            'month' => $slot->slot_date->month,
            'day' => $slot->slot_date->day,
        ]);
    }
}
