<?php

use Illuminate\Http\Request;

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
    Route::get('/getlast', 'ApiController@getLastArticles');
    Route::get('/getpinned', 'ApiController@getPinnedArticle');


    Route::post('articles', 'ApiController@storeArticle');
    Route::get('/getarticle/{id}', 'ApiController@getArticle');
    Route::patch('/update/{article}', 'ApiController@updateArticle');
    Route::delete('/getarticle/{id}', 'ApiController@destroyArticle');

    Route::get('/{id}/deactivate', 'ApiController@deactivateArticle');
    Route::get('/{id}/activate', 'ApiController@activateArticle');
});