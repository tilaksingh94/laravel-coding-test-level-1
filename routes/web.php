<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/events', 'EventController@index')->name('events');
Route::get('/events/ajax', 'EventController@eventsAjax')->name('eventsAjax');
Route::get('/events/create', 'EventController@create')->name('createEvent');
Route::get('/events/{id}', 'EventController@show')->name('showEvent');
Route::post('/events/create/save', 'EventController@store')->name('saveEvent');
Route::get('/events/{id}/edit', 'EventController@edit')->name('e-edit');
Route::post('/events/update/{id}', 'EventController@update')->name('eventUpdate');
Route::get('/events/delete/{id}', 'EventController@destroy')->name('e-delete');
