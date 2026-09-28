<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\MetadataDokumenLegal;
use Illuminate\Support\Facades\View;
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
        Carbon::setLocale('id');
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('IT')
                    ->icon('heroicon-o-code'),
            ]);
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Accounting')
                    ->icon('heroicon-o-calculator'),
            ]);
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Penjualan')
                    ->icon('heroicon-o-calculator'),
            ]);
        });
        
        
        View::composer('*', function ($view) {

        $notifLegal = MetadataDokumenLegal::whereIn('status', [
            'jadwal pembaharuan',
            'kadaluarsa',
            'putus'
        ])->count();

        $view->with('notifLegal', $notifLegal);
    });
       
    }
}
