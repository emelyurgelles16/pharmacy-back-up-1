<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Observers\ProductObserver;
use App\Services\BarcodeService;  
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CreateBackupCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register BarcodeService as a singleton
        $this->app->singleton(BarcodeService::class, function ($app) {
            return new BarcodeService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the Product Observer
        Product::observe(ProductObserver::class);
        
        // Custom Reset Password URL
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return URL::to('/reset-password/' . $token) . '?email=' . urlencode($user->email);
        });

        // ✅ Schedule backup command
        Schedule::command(CreateBackupCommand::class)->dailyAt('12:00');
    }
}