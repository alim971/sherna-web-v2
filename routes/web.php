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

    Route::group(['prefix' =>'summernote'], function (){
        Route::get('/getImage/{name}', 'Admin\ImageController@getImage')->name('image.get');
        Route::post('/saveImage', 'Admin\ImageController@saveImage')->name('image.save');
    });

    Route::group(['prefix' => 'documents'], function () {
        Route::get('/', 'Admin\DocumentController@index')->name('document.index');
        Route::post('/upload', 'Admin\DocumentController@upload')->name('document.upload');;
        Route::get('/{path}', 'Admin\DocumentController@delete')->name('document.delete');;
    });

    Route::get('/oauth', 'Auth\LoginController@oAuthCallback')->name('oauth');
    Route::get('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/authorize', 'Auth\LoginController@getAuthorize')->name('authorize');

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::post('/user', 'Auth\LoginController@postUserData')->name('user.data');


    Route::get('admin', 'Admin\AdminController')->name('admin.index');

    Route::resource('admin/game', 'Admin\GameController');
    Route::resource('admin/console', 'Admin\ConsoleController');
    Route::resource('admin/console/type', 'Admin\ConsoleTypeController');
    Route::resource('admin/inventory', 'Admin\InventoryController', ['only' => [
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]]);
    Route::resource('admin/inventory/category', 'Admin\InventoryCategoryController', [
        'as' => 'inventory',
    ]);

    Route::get('', 'User\PagesController@home')->name('index');

    Route::get('admin/page/standalone', 'Admin\PageController@standalone')
        ->name('page.standalone');

    Route::get('admin/page/navigation', 'Admin\PageController@navigation')
        ->name('page.navigation');

    Route::get('admin/page/subnavigation', 'Admin\PageController@subnavigation')
        ->name('page.subnavigation');

    Route::delete('admin/page/{page}/{type}', 'Admin\PageController@destroy')
        ->name('page.destroy');

    Route::get('admin/page/{page}/{type}', 'Admin\PageController@edit')
        ->name('page.edit');

    Route::put('admin/page/{page}/{type}', 'Admin\PageController@update')
        ->name('page.update');

    Route::get('admin/page/{page}/{type}/public', 'Admin\PageController@public')
        ->name('page.public');

    Route::get('admin/users/auto', 'Admin\UserController@auto')
        ->name('user.auto');

    Route::get('admin/users/index', 'Admin\UserController@index')
        ->name('user.index');

    Route::get('admin/users/filter', 'Admin\UserController@indexFilter')
        ->name('user.filter');

    Route::get('admin/users/{user}/ban', 'Admin\UserController@ban')
        ->name('user.ban');

    Route::put('admin/users/{user}/role', 'Admin\UserController@updateRole')
        ->name('user.role');

    Route::resource('admin/reservation', 'Admin\ReservationController', [
        'as' => 'admin'
    ]);

    Route::get('admin/article/auto', 'Admin\ArticleCategoryController@auto')
        ->name('article.auto');
    Route::resource('admin/category', 'Admin\ArticleCategoryController');

    Route::get('admin/article/{article}/public', 'Admin\ArticleController@public')
        ->name('article.public');
    Route::resource('admin/article', 'Admin\ArticleController');
    Route::resource('admin/role', 'Admin\RoleController');

    Route::get('admin/permission/generate','Admin\PermissionController@generate')->name('permission.generate');
    Route::resource('admin/permission', 'Admin\PermissionController',['only' => [
        'index', 'edit', 'update', 'destroy'
    ]]);
    Route::resource('admin/location', 'Admin\LocationController');
    Route::resource('admin/location/status', 'Admin\LocationStatusController');

    Route::get('pages/{page}/{subpage?}', 'User\PagesController@show')->name("pages.show");

    Route::get('admin/navigation/{navigation}/public', 'Admin\NavigationController@public')
        ->name('navigation.public');
    Route::post('admin/navigation//reorder', 'Admin\NavigationController@reorder')
        ->name('navigation.reorder');
    Route::resource('admin/navigation', 'Admin\NavigationController', ['only' => [
        'index', 'create', 'store', 'edit', 'update', 'destroy',
    ]]);

    Route::get('admin/subnavigation/{subnavigation}/public', 'Admin\SubpageController@public')
        ->name('subnavigation.public');
    Route::post('admin/subnavigation/reorder', 'Admin\SubpageController@reorder')
        ->name('subnavigation.reorder');
    Route::resource('admin/subnavigation', 'Admin\SubpageController', ['only' => [
       'index', 'store', 'create', 'edit', 'update', 'destroy',
    ]]);

    Route::get('admin/settings', 'Admin\SettingController@index')->name('settings.index');
    Route::put('admin/settings', 'Admin\SettingController@update')->name('settings.update');


    Route::post('reservations', 'User\ReservationController@getReservations')
        ->name('getReservations');
    Route::resource('reservation', 'User\ReservationController');


//Route::resource('comment', 'CommentController');

    Route::post('comment/{article}', 'CommentController@store')->name('comment.store');
    Route::put('comment/{comment}', 'CommentController@update')->name('comment.update');
    Route::put('comment/{comment}', 'CommentController@destroy')->name('comment.destroy');
    Route::put('comment/{comment}/edit', 'CommentController@edit')->name('comment.edit');
    Route::post('comment/reply/store', 'CommentController@replyStore')->name('comment.reply');

    Route::get('contact', 'ContactController@show')->name('contact.show');
    Route::post('contact', 'ContactController@send')->name('contact.send');


    Route::get('/about/{page}', 'User\AboutController@show');
    Route::get('/o-nas/{page}', 'User\AboutController@show');
    Route::get('/blog', 'User\BlogController@index')->name('blog');
    Route::get('/blog/categories', 'User\BlogController@categories')->name('blog.categories');
    Route::get('/blog/{article}', 'User\BlogController@show')->name('blog.show');//->where('article', '(.*)');
    Route::get('/lang/{code}', 'User\LanguageController')->name('language');
});
