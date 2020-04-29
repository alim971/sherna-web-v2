<?php

namespace App\Providers;

use App\Language;
use App\Nav\Page;
use App\Nav\SubPage;
use Illuminate\Support\ServiceProvider;

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
        Builder::defaultStringLength(191);
        //
//        \View::composer('layouts.client', function ($view) {
//            //TODO: GET FROM DATABASE
//            $view->with('nav_pages', Page::all()->sortBy('order'));
//            $view->with('languages', Language::all());
//        });
    }
}
