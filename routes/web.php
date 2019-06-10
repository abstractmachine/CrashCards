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
Route::get('/home', 'WorkshopController@index')->name('home');

Route::middleware(['auth'])->group(function () {

	//                       __        __
	//  _      ______  _____/ /_______/ /_  ____  ____  _____
	// | | /| / / __ \/ ___/ //_/ ___/ __ \/ __ \/ __ \/ ___/
	// | |/ |/ / /_/ / /  / ,< (__  ) / / / /_/ / /_/ (__  )
	// |__/|__/\____/_/  /_/|_/____/_/ /_/\____/ .___/____/
	//                                        /_/

	Route::get('/workshops', 'WorkshopController@indexWorkshops')->name('workshops-manager');
	Route::get('/workshops/add', 'WorkshopController@create')->name('add-workshop');
	Route::post('/workshops/{workshop}/remove', 'WorkshopController@destroy')->name('remove-workshop');
	Route::post('/workshops/{workshop}/update', 'WorkshopController@updateWorkshop')->name('update-workshop');
	Route::get('/workshops/{workshop}', 'WorkshopController@indexWorkshop')->name('workshop-entry');
	// Route::post('/workshops/{workshop}/update', 'WorkshopController@updateWorkshop')->name('workshop-entry');

	//    ______           __
	//   / ____/___ ______/ /____  _____
	//  / /   / __ `/ ___/ __/ _ \/ ___/
	// / /___/ /_/ / /  / /_/  __(__  )
	// \____/\__,_/_/   \__/\___/____/
	
	Route::get('/cards', 'CardController@index')->name('cards-manager');
	Route::post('/cards/add', 'CardController@create')->name('add-card');
	Route::post('/cards/remove', 'CardController@destroy')->name('remove-card');
	Route::post('/cards/update', 'CardController@update')->name('update-card');

	//     ____            __
	//    / __ \___  _____/ /_______
	//   / / / / _ \/ ___/ //_/ ___/
	//  / /_/ /  __/ /__/ ,< (__  )
	// /_____/\___/\___/_/|_/____/
	
	Route::get('/decks', 'DeckController@index')->name('decks-manager');
	Route::get('/decks/add', 'DeckController@create')->name('add-deck');
	Route::post('/decks/remove', 'DeckController@destroy')->name('remove-deck');
	Route::post('/decks/{deck}/update', 'DeckController@update')->name('update-deck');
	Route::get('/decks/{deck}', 'DeckController@indexDeck')->name('deck-manager');

	Route::post('/decks/{deck}/category/add', 'DeckController@addCategory')->name('add-category');
	Route::post('/decks/{deck}/category/update', 'DeckController@updateCategory')->name('update-category');
	Route::post('/decks/{deck}/category/delete', 'DeckController@deleteCategory')->name('delete-category');
	
	Route::post('/decks/{deck}/cards/update', 'DeckController@updateCards')->name('update-cards-category');

	Route::post('/decks/{deck}/cards/detach/{card}/category/{category}', 'DeckController@detachCard')->name('detach-card-deck');
	// Route::post('/decks/{deck}/cards/save/{card}/category/{category}', 'DeckController@saveCard')->name('save-card-deck');

	Route::post('/categories/{category}/save/name', 'CategoryController@saveName')->name('save-name-category');
	Route::post('/categories/{category}/delete', 'CategoryController@destroy')->name('delete-category');


	//    __  __
	//   / / / /_______  _____
	//  / / / / ___/ _ \/ ___/
	// / /_/ (__  )  __/ /
	// \____/____/\___/_/
	
	Route::get('/user', 'UserController@index')->name('user');
	Route::post('/users/{user}/update', 'UserController@update')->name('update-user');

});