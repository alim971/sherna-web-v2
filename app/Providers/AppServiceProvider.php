<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;


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
