<?php

use Illuminate\Support\Facades\Auth;
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
})->name('home');

Route::group(['middleware' => ['auth']],function () {
    Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function(){
        /*  Route::prefix('stores')->name('stores.')->group(function(){
     
             Route::get('/', 'StoreController@index')->name('index');
             Route::get('/create', 'StoreController@create')->name('create');;
             Route::post('/store', 'StoreController@store')->name('store');;
             Route::get('/{store}/edit', 'StoreController@edit')->name('edit');;
             Route::post('/update/{store}', 'StoreController@update')->name('update');;
             Route::get('/destroy/{store}', 'StoreController@destroy')->name('destroy');;
             
         }); */
     
     
         Route::resource('stores', StoreController::class);
         Route::resource('products', ProductController::class);
         Route::resource('categories', CategoryController::class);
         
     });
     
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
