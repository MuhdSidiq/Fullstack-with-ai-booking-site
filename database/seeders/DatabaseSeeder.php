<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking; // Added Booking model
use App\Models\CampingSite; // Added CampingSite model
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        CampingSite::factory(10)->create(); // Seed 10 camping sites
        User::factory(20)->create();
        Booking::factory(50)->create(); // Added Booking factory to seed 50 bookings
    }
}
