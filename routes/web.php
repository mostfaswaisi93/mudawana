<?php

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'admin'], function () {
    Route::resource('posts', 'PostController');
    Route::post('posts/update', 'PostController@update')->name('posts.update');
    Route::get('posts/destroy/{id}', 'PostController@destroy');
    Route::post('posts/updatePublished/{id}', 'PostController@updatePublished')->name('post.published');

    Route::resource('comments', 'CommentController');
    Route::post('comments/update', 'CommentController@update')->name('comments.update');
    Route::get('comments/destroy/{id}', 'CommentController@destroy');

    Route::resource('tags', 'TagController');
    Route::post('tags/update', 'TagController@update')->name('tags.update');
    Route::get('tags/destroy/{id}', 'TagController@destroy');

    Route::get('lang/{lang}', function ($lang) {
        session()->has('lang') ? session()->forget('lang') : '';
        $lang == 'ar' ? session()->put('lang', 'ar') : session()->put('lang', 'en');
        return back();
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
