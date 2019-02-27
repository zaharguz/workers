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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::group(['prefix' => 'workers'], function() {
    Route::get('/', 'WorkerController@index')->name('workers');
    Route::match(['get', 'post'], 'create', 'WorkerController@create')->name('create_worker');
    Route::match(['get', 'put', 'post'], 'update/{id}', 'WorkerController@update')->name('update_worker');
    Route::get('show/{id}', 'WorkerController@show')->name('show_worker');
    Route::delete('delete/{id}', 'WorkerController@destroy')->name('delete_worker');
    Route::post('/find', 'WorkerController@find')->name('find_worker');
});
