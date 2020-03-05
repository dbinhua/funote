<?php

Route::prefix('frontend')->namespace('Frontend')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('checkSlug', 'ArticleController@checkSlug');
    });
});

//Route::prefix('backend')->namespace('Admin')->group(function () {
//    Route::get('index', 'ArticleController@index');
//    Route::get('create', 'ArticleController@create');
//    Route::post('store', 'ArticleController@store');
//});


