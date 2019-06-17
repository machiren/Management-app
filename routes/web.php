<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/','MemberController@index');
Route::get('/create','MemberController@create');
Route::post('/create/store','MemberController@store');
Route::get('/sample',function(){
  return view('sample.sample');
});
