<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/test', 'HomeController@test');


/* Data Client Model */
Route::get('/data_clients/{id?}', 'DataClientController@index');
Route::post('/data_clients', 'DataClientController@create');
Route::post('/data_clients/{id}', 'DataClientController@update');
Route::delete('/data_clients/{id}', 'DataClientController@delete');
