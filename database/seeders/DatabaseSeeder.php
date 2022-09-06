<?php

namespace Database\Seeders;

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
        $this->call(defaultAdmin::class);
        $this->call(CountriesSeeder::class);
        $this->call(SettingSeeder::class);
    }
}