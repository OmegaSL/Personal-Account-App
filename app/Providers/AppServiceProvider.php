<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Database\Seeders\SettingSeeder;
use Illuminate\Support\Facades\Schema;
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

    protected function databaseExists($databaseName)
    {
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$databaseName'";
        $result = DB::select($query);

        return count($result) > 0;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $setting = \App\Models\Setting::first() ?? null;

        // check if database exist, if not exist then create the database
        $databaseName = config('database.connections.mysql.database');

        if (!$this->databaseExists($databaseName)) {
            $charset = config('database.connections.mysql.charset', 'utf8mb4');
            $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

            DB::statement("CREATE DATABASE $databaseName CHARACTER SET $charset COLLATE $collation");
        }

        // check if setting is not null, if not null then run the SettingSeeder to create the setting
        if ($setting == null) {
            // run the migration
            Artisan::call('migrate');
            // run the seeder
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
