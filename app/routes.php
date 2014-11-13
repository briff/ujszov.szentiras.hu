<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::controller("/technikai", "TechnicalController");

Route::get("/details/{id}", "TextController@getDetails");

Route::controller("/text/{book?}/{chapter?}/{verse?}", "TextController");
Route::controller("/board", "BoardController");

Route::get('/help.html', function() { return Redirect::to('/help', 301); });
Route::get('/rovjegyz.htm', function() { return Redirect::to('/rovjegyz', 301);});
Route::get('/linkek.html', function() { return Redirect::to('/linkek', 301);});
Route::get('/letolthetok.html', function() { return Redirect::to('/download', 301);});
Route::get('/level.php', function() { return Redirect::to('/board', 301);});

Route::controller('/', 'HomeController');