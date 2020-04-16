<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::middleware('authenticate')->group(function () {

    Route::get('', 'WelcomeController');



    Route::resource('article', 'ArticleController');
    Route::resource('admin/role', 'Admin\RoleController');
    Route::resource('admin/user', 'Admin\UserController',['only' => [
        'index', 'show', 'edit', 'destroy', 'update'
    ]]);
    Route::get('admin/permission/generate','Admin\PermissionController@generate')->name('permission.generate');
    Route::resource('admin/permission', 'Admin\PermissionController',['only' => [
        'index', 'show', 'edit', 'update'
    ]]);
    Route::resource('admin/location', 'Admin\LocationController');
    Route::resource('admin/status', 'Admin\LocationStatusController');

    Route::get('pages/{page}/{subpage?}', 'User\PagesController@show')->name("pages.show");

    Route::get('admin/navigation/{navigation}/public', 'Admin\NavigationController@public')
        ->name('navigation.public');
    Route::resource('admin/navigation', 'Admin\NavigationController', ['only' => [
        'index', 'create', 'store', 'edit', 'update', 'destroy',
    ]]);

    Route::get('admin/subnavigation/{subnavigation}/public', 'Admin\SubpageController@public')
        ->name('subnavigation.public');
    Route::resource('admin/subnavigation', 'Admin\SubpageController', ['only' => [
       'index', 'store', 'create', 'edit', 'update', 'destroy',
    ]]);

    Route::get('admin/settings', 'Admin\SettingController@index')->name('settings.index');
    Route::put('admin/settings', 'Admin\SettingController@update')->name('settings.update');

    Route::resource('reservation', 'User\ReservationController');


//Route::resource('comment', 'CommentController');

    Route::post('comment/{article}', 'CommentController@store')->name('comment.store');
    Route::put('comment/{comment}', 'CommentController@update')->name('comment.update');
    Route::put('comment/{comment}', 'CommentController@destroy')->name('comment.destroy');
    Route::put('comment/{comment}/edit', 'CommentController@edit')->name('comment.edit');
    Route::post('comment/reply/store', 'CommentController@replyStore')->name('comment.reply');

    Route::get('contact', 'ContactController@show')->name('contact.show');
    Route::post('contact', 'ContactController@send')->name('contact.send');

    Auth::routes();

    Route::get('/about/{page}', 'User\AboutController@show');
    Route::get('/o-nas/{page}', 'User\AboutController@show');
    Route::get('/blog', 'User\BlogController@index')->name('blog');
    Route::get('/blog/{article}', 'User\BlogController@show')->where('article', '(.*)');
    Route::get('/lang/{code}', 'User\LanguageController')->name('language');
});
