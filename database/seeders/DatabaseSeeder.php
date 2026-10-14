<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed a local demo account (username "demo", password "calmify-demo")
     * with the two trusted people shown in the UI mockups.
     */
    public function run(): void
    {
        $user = User::factory()->withHealthDataConsent()->create([
            'username' => 'demo',
            'password' => 'calmify-demo',
        ]);

        $user->emergencyContacts()->createMany([
            ['name' => 'Lena', 'relation' => 'Schwester', 'phone_number' => '+49 170 0000001'],
            ['name' => 'Dr. Berger', 'relation' => 'Therapeutin', 'phone_number' => '+49 170 0000002'],
        ]);
    }
}
