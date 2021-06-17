<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'dashboard'])->group(function () {
	Route::get('/home', 'HomeController@index')->name('home');

	Route::namespace('User')->group(function () {
		Route::get('authenticated-user', 'ProfileController@getAuthenticatedUser');
		Route::get('address', 'ProfileController@address');
	});

	Route::namespace('Categories')->prefix('categories')->group(function () {
		Route::get('all', 'CategoriesController@all');
	});

	Route::namespace('Products')->prefix('products')->group(function () {
		Route::get('all', 'ProductsController@all');
	});

	Route::namespace('Carts')->prefix('carts')->group(function () {
		Route::get('all', 'CartsController@all');
		Route::post('store', 'CartsController@addItemToCart');
		Route::delete('destroy/{id}', 'CartsController@destroy')->where('id', '[0-9]+');
	});

	Route::namespace('Orders')->prefix('orders')->group(function () {
		Route::post('store', 'OrdersController@store');
	});
});
