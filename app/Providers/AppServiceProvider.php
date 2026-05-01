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

//     private function loadHeaderCountryData()
// {
//     View::composer('user.layout.header', function ($view) {
//         $view->with('GetsellerCountry', \App\Models\all_countrie::get());
//     });
// }

private function loadHeaderCountryData()
{
    View::composer('user.layout.header', function ($view) {
        $view->with('GetsellerCountry', \App\Models\all_countrie::whereIn('id', function($query) {
            $query->selectRaw('MIN(id)')
                  ->from('all_countries')
                  ->groupBy('currency_code');
        })->get());
    });
}


}