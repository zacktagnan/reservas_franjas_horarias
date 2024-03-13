<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BarberShopSeeder extends Seeder
{
    protected $barberShopsDefault;
    protected $schedulesDefault_1, $schedulesDefault_2;

    public function __construct()
    {
        $this->barberShopsDefault = [
            [
                'name' => 'Barbería 1',
                'phone' => '654789321',
                'address' => 'Calle 123',
                'image' => fake()->imageUrl(word: 'Barbería 1'),
                'max_future_days' => 7,
                'slot_duration' => 30,
            ],
            [
                'name' => 'Barbería 2',
                'phone' => '943485236',
                'address' => 'Calle 321',
                'image' => fake()->imageUrl(word: 'Barbería 2'),
                'max_future_days' => 5,
                'slot_duration' => 60,
            ],
        ];

        $this->schedulesDefault_1 = [
            [
                'day_of_week' => 1,
                'open_time' => '08:00',
                'close_time' => '17:00',
            ],
            [
                'day_of_week' => 2,
                'open_time' => '08:00',
                'close_time' => '17:00',
            ],
            [
                'day_of_week' => 3,
                'open_time' => '08:00',
                'close_time' => '17:00',
            ],
            [
                'day_of_week' => 4,
                'open_time' => '08:00',
                'close_time' => '17:00',
            ],
            [
                'day_of_week' => 5,
                'open_time' => '08:00',
                'close_time' => '17:00',
            ],
            [
                'day_of_week' => 6,
                'open_time' => '08:00',
                'close_time' => '12:00',
            ],
            [
                'day_of_week' => 7,
                'is_closed' => true,
            ],
        ];

        $this->schedulesDefault_2 = [
            [
                'day_of_week' => 1,
                'open_time' => '08:00',
                'close_time' => '20:00',
            ],
            [
                'day_of_week' => 2,
                'open_time' => '08:00',
                'close_time' => '18:00',
            ],
            [
                'day_of_week' => 3,
                'open_time' => '08:00',
                'close_time' => '17:00',
            ],
            [
                'day_of_week' => 4,
                'open_time' => '08:00',
                'close_time' => '14:00',
            ],
            [
                'day_of_week' => 5,
                'open_time' => '08:00',
                'close_time' => '17:00',
            ],
            [
                'day_of_week' => 6,
                'is_closed' => true,
            ],
            [
                'day_of_week' => 7,
                'is_closed' => true,
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->barberShopsDefault as $row) {
            $barberShop = \App\Models\BarberShop::create([
                'name' => $row['name'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'image' => $row['image'],
                'max_future_days' => $row['max_future_days'],
                'slot_duration' => $row['slot_duration'],
            ]);

            match ($barberShop->id) {
                // 0 => $barberShop->schedules()->createMany([
                //     [...], [...], ...
                // ]),
                // 1 => $barberShop->schedules()->createMany(
                //     $this->schedulesDefault_1
                // ),
                // ------------------------------------------------------------
                1 => $barberShop->schedules()->createMany($this->schedulesDefault_1),
                2 => $barberShop->schedules()->createMany($this->schedulesDefault_2),
                // ------------------------------------------------------------
                // 1 => $this->generateSchedules($barberShop, $this->schedulesDefault_1),
                // 2 => $this->generateSchedules($barberShop, $this->schedulesDefault_2),
            };
        }
    }

    private function generateSchedules(\App\Models\BarberShop $barberShop, array $schedulesDefault): void
    {
        $barberShop->schedules()->createMany($schedulesDefault);
    }
}
