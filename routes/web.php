<?php

Auth::routes();

Route::get('/','MemberController@index');

Route::group(['middleware' => ['auth']], function () {

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/managements/read_list','MemberController@read_list');
Route::get('/managements/month_list','MemberController@month_list');
Route::get('/managements/show/{auth}/{id}','MemberController@show');
Route::get('/managements/{id}/create','MemberController@create');
// Route::get('/managements/confirm','MemberController@confirm');
Route::get('/managements/insert', 'HomeController@insert');
Route::get('/admin/member_list', 'AdminController@member_list');
Route::get('/admin/year_list/{id}', 'AdminController@year_list');
Route::get('/admin/month_list/{id}/{year}', 'AdminController@month_list');
Route::get('/admin/show_list/{id}/{year}/{month}','AdminController@show_list');
Route::get('/admin/{id}/{year}/{month}/edit','AdminController@edit');
Route::put('/admin/update','AdminController@update');
Route::post('/admin/{id}/{year}/{month}/delete','AdminController@delete');

Route::resource('managements','MemberController',['only' => ['index','store','update']]);

});