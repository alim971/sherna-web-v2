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

Route::get('', 'WelcomeController');


Route::resource('article', 'ArticleController');


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
