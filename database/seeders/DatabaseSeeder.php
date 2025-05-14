<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CompanySetting;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => bcrypt('123456789'),
        'role' => 'admin',
    ]);

    CompanySetting::factory()->create([
        'name' => 'PT. Cukuurukuk Jaya',
        'description' => 'ngoding aja terus',
        'address' => 'Jl. Raya No. 1 serangg Indonesia 12345 ',
        'phone' => '+62 123 4567 890',
        'value' => 'Berani Berubah untuk serang',

    ]);

    }
}
