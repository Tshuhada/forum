<?php

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/topics/create', 'TopicController@create')->name('topics.create');
Route::post('/topics/create', 'TopicController@store');

Route::get('/topics', 'TopicController@index');
Route::get('/topics/{slug}', 'TopicController@show');

Route::get('/topics/{slug}/edit', 'TopicController@edit')->name('topics.edit');
Route::post('/topics/{slug}/edit', 'TopicController@update');
