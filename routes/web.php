<?php

//用户注册、登录
Auth::routes(['register' => false]);

//微博三方登录
Route::get('weibo', 'WeiboAuthController@index')->name('weibo.login');
Route::get('auth-weibo', 'WeiboAuthController@rollback')->name('weibo.rollback');
Route::get('share-weibo', 'WeiboAuthController@share')->name('weibo.share')->middleware('auth');

//前端路由
Route::get('/', 'IndexController@index')->name('index');
Route::get('detail/{slug}', 'ArticleController@detail')->name('detail');
Route::get('chat', 'ChatController@index')->name('chat');

//写作中心
Route::prefix('article')->middleware('auth')->group(function (){
    Route::get('create', 'ArticleController@writingPage')->name('article.edit');
    Route::post('create', 'ArticleController@create')->name('article.create');
});

//个人中心

Route::prefix('user')->middleware('auth')->group(function (){
    Route::get('edit', 'UserController@edit')->name('user.edit');
});
Route::get('user/{id}', 'UserController@index')->name('user');

//管理中心
Route::prefix('manager')->middleware('auth')->group(function (){
    Route::get('/', 'ManagerController@index')->name('manager');
});

//api
Route::prefix('api')->middleware('auth')->group(function (){
    //写作中心
    Route::post('checkSlug', 'ArticleController@checkSlug');

    //个人中心
    Route::prefix('user')->group(function (){
        Route::post('update', 'UserController@update');
        Route::post('uploadImg', 'UserController@uploadImg');
    });
});

//更新日志
//Route::get('updatelog/{module}', 'UpdateLogController@index')->name('updatelog.chat');
//Route::get('wiki', 'IndexController@wiki')->name('wiki');
//Route::get('blog','BlogController@index')->name('blog');
