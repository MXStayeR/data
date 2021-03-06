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
    if( Auth::guest()){
        return view('layouts/no_auth');
    } else {
        return redirect('/clients');
    }
});

Auth::routes();

//Route::get('/test', 'HomeController@test');
Route::get('/home', 'HomeController@index');


Route::group(['middleware' => 'auth'], function () {

    /* Data Client Model */
    Route::get('/clients/{id?}', 'DataClientController@index')->name('clients');
    Route::post('/clients', 'DataClientController@create');
    Route::post('/clients/{id}', 'DataClientController@update');
    Route::delete('/clients/{id}', 'DataClientController@delete');

    Route::any('/statistics/requests', 'StatisticsController@requests')->name('request_statistics');
    Route::any('/statistics/data', 'StatisticsController@data')->name('data_statistics');

//    Route::get('/client_pixel/{id?}', function($id){
//        return view('client_pixel')->with('id', $id);
//    })->name('client_pixel');
//
//    Route::get("/pixel/{token?}", 'PixelController@index')->name('pixel');

});

