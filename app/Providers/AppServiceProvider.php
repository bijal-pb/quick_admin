<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class); 
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('settings')) {
            $settings = Setting::latest()->first();
            if($settings){
                config()->set('settings', $settings);
                Config::set([
                    'app.name' => \config('settings.name'),
                    'app.url' => \config('settings.url'),
                    'app.env' => \config('settings.env'),
                    'app.debug' => \config('settings.debug'),
                ]);
            }
        }
        
    }
}
