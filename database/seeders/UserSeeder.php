<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected $usersDefault;

    public function __construct()
    {
        $this->usersDefault = [
            [
                'name' => 'Admin Test',
                'email' => 'admin@test.es',
                'password' => Hash::make('12345678'),
                'credit' => 7,
            ],
            [
                'name' => 'User Test',
                'email' => 'user@test.es',
                'password' => Hash::make('xxxxxxxx'),
                'credit' => 4,
            ],
            [
                'name' => 'Maitetxu Mía',
                'email' => 'nere-maitia@hori.da',
                'password' => Hash::make('74117428'),
                'credit' => 28,
            ],
            [
                'name' => 'PJ-CM',
                'email' => 'peio@ni.naiz',
                'password' => Hash::make('74117428'),
                'credit' => 11,
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->usersDefault as $row) {
            \App\Models\User::factory()->create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => $row['password'],
                'credit' => $row['credit'],
            ]);
        }
    }
}
