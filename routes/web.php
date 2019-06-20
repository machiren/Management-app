<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/','MemberController@index');
Route::get('/create','MemberController@create');
Route::get('/list','MemberController@list');
Route::post('/create/store','MemberController@store');
