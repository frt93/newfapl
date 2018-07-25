<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix' => 'articles'], function () {
    Route::get('/', 'ArticlesController@index');
    Route::get('/pinned', 'ArticlesController@getPinnedArticle');
    Route::get('/create', 'ArticlesController@create');
    Route::get('/{id}', 'ArticlesController@show');
    Route::get('/{id}/edit', 'ArticlesController@edit');

    Route::post('/store', 'ArticlesController@store');
    Route::patch('/update/{article}', 'ArticlesController@update');
    Route::delete('/getarticle/{id}', 'ArticlesController@destroy');

    Route::get('/{id}/unpublish', 'ArticlesController@unPublish');
    Route::get('/{id}/publish', 'ArticlesController@publish');
});

Route::get('/filters', 'ApiController@index');