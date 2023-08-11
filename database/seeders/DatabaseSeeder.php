<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        SettingSeeder::class;

        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '1234567890',
            'avatar_url' => null,
            // 'avatar_url' => 'https://ui-avatars.com/api/?name=Super+Admin&color=7F9CF5&background=EBF4FF',
            'address' => '123 Main St',
            'city' => 'New York',
            'country' => 'USA',
            'postal_code' => '12345',
            'birth_date' => '1990-01-01',
            'basic_balance' => 1000000,
            'status' => true,
            'password' => bcrypt('password'),
        ]);
        \App\Models\User::factory(10)->create();
        \App\Models\PaymentMethod::factory(2)->create();
        \App\Models\FaqCategory::factory(5)->create();
        \App\Models\Faq::factory(25)->create();
        \App\Models\Deduction::factory(5)->create();
        \App\Models\DeductionHistory::factory(25)->create();
    }
}
