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

// Route::get('/', function () {

//     return view('dashboard');

// })->middleware('auth');

// enable auth routes except for register ones
Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('dashboard');

// using statefull routing with sessions for now
// normaly this would sit in the api.php file with 
// any kind of token based auth 
Route::resource('companies', 'CompanyController')->except(['edit','create'])->middleware('auth');
