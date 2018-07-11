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


use App\User;
use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

Route::resource('articles', 'ArticlesController');
Route::get('articles/{id}/deactivate', 'ArticlesController@deactivate');
Route::get('articles/{id}/activate', 'ArticlesController@activate');


Route::group(['prefix' => 'api'], function () {
    Route::get('/', 'ApiController@index')->name('api');

    Route::post('/auth/signin', 'Auth\LoginController@login')->name('ajax.signin');
    Route::get('/checkauth', 'Auth\LoginController@CheckAuthorizationStatus')->name('check.auth');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('signin/{provider}', 'Auth\LoginController@redirectToProvider')->name('socialite.auth');
Route::get('signin/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('gettoken', function() {
    $user = User::where('id', '=', 1)->first();
   return $user->id;
});