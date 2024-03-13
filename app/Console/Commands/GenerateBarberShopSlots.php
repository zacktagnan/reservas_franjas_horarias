<?php

namespace App\Console\Commands;

use App\Models\BarberShop;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class GenerateBarberShopSlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-barber-shop-slots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate barber shop slots for days';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        /** @var \Illuminate\Database\Eloquent\Collection<BarberShop> */
        $barberShops = BarberShop::with('slots', 'schedules')->get();
        // dd($barberShops);

        foreach ($barberShops as $barberShop) {
            // dd($barberShop->slots->count());
            if (!$barberShop->slots->count()) {
                $this->generateInitialSlotsForBusiness($barberShop);

                continue;
            }

            // if barberShop has slots, check if the last slot is older than max_future_days
            $lastSlot = $barberShop->slots->sortByDesc('slot_date')->first();
            $endDate = now()->addDays($barberShop->max_future_days);
            if ($lastSlot->slot_date->lt($endDate)) {
                $this->generateNewSlotsForBusiness($barberShop, $lastSlot->slot_date, $endDate);
            }
        }
    }

    private function generateInitialSlotsForBusiness(BarberShop $barberShop): void
    {
        $startDate = now();
        $endDate = now()->addDays($barberShop->max_future_days);
        // dd($barberShop->max_future_days, $startDate, $endDate);
        while ($startDate->lt($endDate)) {
            $this->createSlots($startDate, $barberShop);
        }
    }

    private function generateNewSlotsForBusiness(BarberShop $barberShop, Carbon $slotDate, Carbon $endDate): void
    {
        $startDate = $slotDate->addDay();
        while ($startDate->lt($endDate)) {
            $this->createSlots($startDate, $barberShop);
        }
    }

    private function createSlots(Carbon $startDate, BarberShop $barberShop): void
    {
        // dd($startDate, $barberShop);
        if ($barberShop->slots->where('slot_date', $startDate->toDateString())->count()) {
            return;
        }

        $dayOfWeek = $startDate->dayOfWeek;
        // dd($dayOfWeek);
        $schedule = $barberShop->schedules->where('day_of_week', $dayOfWeek)->where('is_closed', false)->first();
        // dd($schedule);

        if ($schedule) {
            // dd('Schedule existe...');
            $openTime = now()->setTimeFromTimeString($schedule->open_time);
            $closeTime = now()->setTimeFromTimeString($schedule->close_time);
            $slots = collect();
            while ($openTime->lt($closeTime)) {
                $slots->push([
                    'slot_date' => $startDate->toDateString(),
                    'start_time' => $openTime->copy()->toTimeString(),
                    'end_time' => $openTime->copy()->addMinutes($barberShop->slot_duration)->toTimeString(),
                ]);
                $openTime->addMinutes($barberShop->slot_duration);
            }
            $barberShop->slots()->createMany($slots->toArray());
        }
        $startDate->addDay();
    }
}
