<?php

namespace Database\Seeders;

use App\Models\Setting;

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
        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
            $setting->name = 'ingeniousmindslab';
            $setting->url = 'https://ingeniousmindslab.com/';
            $setting->push_token = '';
            $setting->api_log = '';
            $setting->host = '';
            $setting->port = '';
            $setting->email = 'admin@admin.com';
            $setting->password = '123456789';
            $setting->from_address = '';
            $setting->from_name = '';
            $setting->encryption = '';
            $setting->save();
        }
    }
}
