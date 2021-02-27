<?php

//用户注册、登录
Auth::routes(['register' => false]);

//微博三方登录
Route::prefix('weibo')->name('weibo.')->group(function (){
    Route::get('/', 'WeiboAuthController@index')->name('login');
    Route::get('auth', 'WeiboAuthController@rollback')->name('rollback');
    Route::get('share', 'WeiboAuthController@share')->name('share')->middleware('auth');
});

//前端路由
Route::get('/', 'IndexController@index')->name('index');
Route::get('detail/{slug}', 'ArticleController@detail')->name('detail');
Route::get('chat', 'ChatController@index')->name('chat');

//写作中心
Route::prefix('article')->name('article.')->middleware('auth')->group(function (){
    Route::get('create', 'ArticleController@getCreate')->name('edit');
    Route::post('create', 'ArticleController@postCreate')->name('create');
});

//个人中心
Route::prefix('user')->middleware('auth')->group(function (){
    Route::get('edit', 'UserController@edit')->name('user.edit');
});
Route::get('user/{id}', 'UserController@index')->name('user');

//api
Route::prefix('api')->middleware('auth')->group(function (){
    //写作中心
    Route::prefix('article')->group(function (){
        Route::post('checkSlug', 'ArticleController@checkSlug');
        Route::get('tags/{tagName}', 'ArticleController@searchTagsByName');
    });

    //个人中心
    Route::prefix('user')->group(function (){
        Route::post('update', 'UserController@update');
        Route::post('uploadImg', 'UserController@uploadImg');
        Route::post('sendCaptcha', 'CaptchaController@sendCaptcha');
    });
});

//更新日志
Route::get('devlog/{module}', 'DevLogController@index')->name('devlog.chat');
//Route::get('wiki', 'IndexController@wiki')->name('wiki');
//Route::get('blog','BlogController@index')->name('blog');
