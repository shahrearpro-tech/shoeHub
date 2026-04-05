<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useTailwind();

        // Global settings sharing
        try {
            // Check for missing pdo_mysql driver
            if (!extension_loaded('pdo_mysql')) {
                \Log::warning('CRITICAL: pdo_mysql extension is NOT loaded in this environment.');
                \View::share('settings', []);
                return;
            }

            if (!app()->runningInConsole() && \Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::pluck('setting_value', 'setting_key')->toArray();
                \View::share('settings', $settings);
            }
        } catch (\Exception $e) {
            \Log::error('Settings could not be loaded: ' . $e->getMessage());
            \View::share('settings', []);
        }
    }
}
