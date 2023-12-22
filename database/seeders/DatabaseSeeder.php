<?php

namespace Database\Seeders;

use Database\Factories\SettingFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Constraint\Count;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Mohammed Azharuddin",
            'first_name' => "Mohammed",
            'last_name' => "Azharuddin",
            'email' => 'azharmsc.soft@gmail.com',
            'mobile' => '98595013',
            'username' => '98595013',
            'admin_type' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            // CountrySeeder::class,
        ]);

        \App\Models\Setting::factory(1)->create();

        // \App\Models\User::factory(10)->create();
    }
}
