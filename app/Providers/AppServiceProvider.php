<?php

namespace App\Providers;

use Database\Seeders\SettingSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $setting = \App\Models\Setting::first();
        // check if setting is not null, if not null then run the SettingSeeder to create the setting
        if ($setting == null) {
            Artisan::call('db:seed', [
                '--class' => SettingSeeder::class
            ]);
        }
        // share the setting variable to all the views
        view()->share('setting', $setting);

        // create a macro search for data range in the builder
        Builder::macro('searchDateRange', function ($from, $to) {
            if ($from != null && $to != null) {
                return $this->whereBetween('created_at', [$from, $to]);
            }
            return $this;
        });
    }
}
