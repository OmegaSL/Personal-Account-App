<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Database\Eloquent\Model::unguard();
        \App\Models\Setting::create([
            'site_name' => 'Personal Finance',
            'site_email' => 'admin@admin.com',
            'site_phone' => '0240000000',
            'site_address' => 'Accra, Ghana',
            'about_us' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
            'mission' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
            'vision' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
            'facebook_url' => 'https://facebook.com',
            'twitter_url' => 'https://twitter.com',
            'instagram_url' => 'https://instagram.com',
            'linkedin_url' => 'https://linkedin.com',
            'youtube_url' => 'https://youtube.com',
            'whatsapp_contact' => '0240000000',
            'telegram_contact' => '0240000000',
            'currency' => '₵',
            'transaction_fee' => 0,
            'saving_withdrawal_limit' => 1000,
            'withdrawal_limit_period' => 3,
        ]);
    }
}
