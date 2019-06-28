<?php

Auth::routes();

Route::get('/','MemberController@index');

Route::group(['middleware' => ['auth']], function () {

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/create','MemberController@create');
Route::get('/list','MemberController@list');
Route::post('/create/store','MemberController@store');
Route::post('/create/update','MemberController@update');

});