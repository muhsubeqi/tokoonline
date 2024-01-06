<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 1,
        ]);

        Setting::create([
            'setting' => 'store_name',
        ]);
        Setting::create([
            'setting' => 'store_email',
        ]);
        Setting::create([
            'setting' => 'store_logo',
        ]);
        Setting::create([
            'setting' => 'store_city',
        ]);
        Setting::create([
            'setting' => 'store_address',
        ]);
        Setting::create([
            'setting' => 'store_phone',
        ]);
        Setting::create([
            'setting' => 'bank',
        ]);
        Setting::create([
            'setting' => 'announcement',
        ]);
        Setting::create([
            'setting' => 'sosial_media_1',
        ]);
        Setting::create([
            'setting' => 'sosial_media_2',
        ]);
        Setting::create([
            'setting' => 'sosial_media_3',
        ]);
        Setting::create([
            'setting' => 'advertisement',
        ]);
        Setting::create([
            'setting' => 'banner_home',
        ]);
        Setting::create([
            'setting' => 'slide_1',
        ]);
        Setting::create([
            'setting' => 'slide_2',
        ]);
    }
}