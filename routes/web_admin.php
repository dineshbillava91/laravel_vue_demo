<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Admin\Auth')->prefix('admin')->group(function () {
    Route::get('login', 'LoginController@showLoginForm');
    Route::post('login', 'LoginController@login')->name('login');
});

Route::middleware(['auth', 'admin'])->namespace('Admin')->prefix('admin')->group(function () {
	Route::get('home', 'HomeController@index')->name('home');

    Route::namespace('User')->group(function () {
        Route::get('authenticated-user', 'ProfileController@getAuthenticatedUser');
    });

	Route::namespace('Categories')->prefix('categories')->group(function () {
		Route::get('all', 'CategoriesController@all');
		Route::post('store', 'CategoriesController@store');
		Route::patch('update', 'CategoriesController@update');
		Route::delete('destroy/{id}', 'CategoriesController@destroy')->where('id', '[0-9]+');
	});

	Route::namespace('Products')->prefix('products')->group(function () {
		Route::get('all', 'ProductsController@all');
		Route::post('store', 'ProductsController@store');
		Route::patch('update', 'ProductsController@update');
		Route::delete('destroy/{id}', 'ProductsController@destroy')->where('id', '[0-9]+');
	});

	Route::namespace('Orders')->prefix('orders')->group(function () {
		Route::get('all', 'OrdersController@all');
		Route::delete('destroy/{id}', 'OrdersController@destroy')->where('id', '[0-9]+');
	});
});


Route::get('admin/{param?}', 'Admin\HomeController@index')->where('param', '[\/\w\.-]*');
Route::get('/{param?}', 'HomeController@index')->where('param', '[\/\w\.-]*');
