<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Tables\Columns\Layout\Panel;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */

     public function configurePanel(Panel $panel): void
    {
        $panel
            ->maxContentWidth(10);
            // ... lainnya
    }
    public function boot()
    {
        Filament::serving(function () {
            // For Filament v2, use this instead of brand()
            config(['filament.brand' => 'App Marthys']);
            
            // Optional: Change brand logo
            // config(['filament.brand-logo' => asset('images/logo.png')]);
        });
        
    }
    
}
