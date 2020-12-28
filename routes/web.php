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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('main', 'HomeController@main');


//User
Route::get('users','UserController@index');
Route::get('getUsers','UserController@getUsers');
Route::post('updateUsers','UserController@updateUsers');
Route::post('deleteUsers','UserController@deleteUsers');

//Books
Route::get('books','BookController@index');
Route::get('getBooks','BookController@getData');
Route::post('updateBooks','BookController@update');

//Books
Route::get('bookLogs','BookLogController@index');
Route::get('getBookLogs','BookLogController@getData');
Route::post('updateBookLogs','BookLogController@update');

//Catalog
Route::get('catalog','CatalogController@index');
Route::get('getCatalog','CatalogController@getData');
Route::post('updateCatalogs','CatalogController@update');

//Shelves
Route::get('shelves','ShelvesController@index');
Route::get('getShelves','ShelvesController@getData');
Route::post('updateShelves','ShelvesController@update');

