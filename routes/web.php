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

Auth::routes();

Route::get('/', 'WorkshopController@index')->name('home');

Route::get('/cards', 'CardController@index')->name('cards-manager');
Route::post('/cards/add', 'CardController@create')->name('add-card');
Route::post('/cards/remove', 'CardController@destroy')->name('remove-card');
Route::post('/cards/update', 'CardController@update')->name('update-card');

Route::get('/decks', 'DeckController@index')->name('decks-manager');
Route::post('/decks/add', 'DeckController@create')->name('add-deck');
Route::post('/decks/remove', 'DeckController@destroy')->name('remove-deck');
Route::post('/decks/update', 'DeckController@update')->name('update-deck');
