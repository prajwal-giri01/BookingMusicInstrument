<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
//        View::composer('frontend.Header', function ($view) {
//            $homePageSubtitle = Setting::where('key', 'home-page-subtitle')->first()->value;
//
//            $view->with([
//                'homePageSubtitle' => $homePageSubtitle,
//            ]);
//        });
    }
}
