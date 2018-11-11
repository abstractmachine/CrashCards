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
Route::get('/decks/add', 'DeckController@create')->name('add-deck');
Route::post('/decks/remove', 'DeckController@destroy')->name('remove-deck');
Route::post('/decks/update', 'DeckController@update')->name('update-deck');

Route::middleware(['auth'])->group(function () {

	Route::get('/decks/deck/{deck}', 'DeckController@indexDeck')->name('deck-manager');
	Route::post('/decks/deck/{deck}/addcategory', 'DeckController@addCategory')->name('add-category');
	Route::post('/decks/deck/{deck}/updatecategory', 'DeckController@updateCategory')->name('update-category');
	Route::post('/decks/deck/{deck}/deletecategory', 'DeckController@deleteCategory')->name('delete-category');
	Route::post('/decks/deck/{deck}/cards/detach/{card}/category/{category}', 'DeckController@detachCard')->name('detach-card-deck');
	Route::post('/decks/deck/{deck}/cards/save/{card}/category/{category}', 'DeckController@saveCard')->name('save-card-deck');

	Route::post('/categories/{category}/save/name', 'CategoryController@saveName')->name('save-name-category');
	Route::post('/categories/{category}/delete', 'CategoryController@destroy')->name('delete-category');


});