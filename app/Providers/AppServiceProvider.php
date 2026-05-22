<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    $this->loadHeaderCountryData();
    
       
    }


// private function loadHeaderCountryData()
// {
//     View::composer('user.layout.header', function ($view) {
//         $view->with(
//             'GetsellerCountry',
//             \App\Models\all_countrie::get()->unique('currency_code')->values()
//         );
//     });
// }

    private function loadHeaderCountryData()
    {
        View::composer('user.layout.header', function ($view) {

            $allowedCurrencies = [
                'KWD',
                'SAR',
                'AED',
                'QAR',
                'OMR',
                'BHD',
                'USD',
                'EUR'
            ];

            $view->with(
                'GetsellerCountry',
                \App\Models\all_countrie::whereIn('currency_code', $allowedCurrencies)
                    ->get()
                    ->unique('currency_code')
                    ->values()
            );
        });
    }


}