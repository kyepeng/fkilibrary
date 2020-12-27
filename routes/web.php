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

Route::group(['middleware' => ['auth']], function()
{
	//need login
	Route::get('/home', 'HomeController@index')->name('home');

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

	//Form
	Route::get('returnbookForm','BookLogController@returnBookForm');
	Route::get('getLogInfo','BookLogController@getLogInfo');
	Route::get('bookForm/{id}','BookLogController@bookForm');
	Route::post('submitBookForm','BookLogController@submitBookForm');

	Route::get('successPage',function(){
		return view('layouts.success');
	});

	Route::get('logout','Auth\LoginController@logout');
});

Route::get('/', function(){
	$path = "main";
	$auth = Auth::user();
	if($auth)
	{
		$path = $auth->type !== "Student" ? "home" : "main";
	}
	return redirect($path);
});
Route::get('main', 'HomeController@main');

Route::get('searchresult','SearchController@index');
Route::get('getSearchResult','SearchController@getData');
//no login
Auth::routes();

