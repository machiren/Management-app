<?php

Auth::routes();

Route::get('/','MemberController@index');

Route::group(['middleware' => ['auth']], function () {

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/managements/list','MemberController@list');
Route::get('/managements/month_list','MemberController@month_list');
Route::get('/managements/show/{auth}/{id}','MemberController@show');
Route::get('/managements/{id}/create','MemberController@create');
Route::resource('managements','MemberController',['only' => ['index','store','update']]);

});