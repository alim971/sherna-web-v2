<?php

namespace App\Providers;

use App\Language;
use App\Nav\Page;
use App\Nav\SubPage;
use Illuminate\Support\Facades\Session;
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
        //
        \View::composer('base', function ($view) {
            //TODO: GET FROM DATABASE
            $view->with('nav_pages', Page::all()->sortBy('order'));
            $view->with('nav_subpages', SubPage::all()->sortBy('order'));
            $view->with('languages', Language::all());
            $view->with('active_lang', Session::get('lang'));
        });
    }
}
