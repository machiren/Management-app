<?php

Auth::routes();

Route::get('/','MemberController@index');

Route::group(['middleware' => ['auth']], function () {

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/managements/list','MemberController@list');
Route::resource('managements','MemberController',['only' => ['index','create','store','edit','update']]);


// Route::get('/create','MemberController@create');
// Route::get('/edit','MemberController@edit');
// Route::get('/list','MemberController@list');
// Route::post('/create/store','MemberController@store');
// Route::post('/edit/update','MemberController@update');

});