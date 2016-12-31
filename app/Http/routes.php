<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api/v1/events/categorys', 'Events@getCategorys');
Route::post('/api/v1/events/categorys', 'Events@createCategorys');
Route::get('/api/v1/events/{id?}', 'Events@index');
Route::post('/api/v1/events', 'Events@store');
Route::post('/api/v1/events/{id?}', 'Events@update');
Route::delete('/api/v1/events/{id}', 'Events@destroy');