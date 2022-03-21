<?php

use App\Http\Controllers\Admin\ProductPhotoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Models\ProductPhoto;
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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/product/{slug}', 'App\Http\Controllers\HomeController@single')->name('product.single');
Route::get('/category/{slug}', 'App\Http\Controllers\CategoryController@index')->name('category.single');
Route::get('/store/{slug}', 'App\Http\Controllers\StoreController@index')->name('store.single');


Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/', 'App\Http\Controllers\CartController@index')->name('index');
    Route::post('add', 'App\Http\Controllers\CartController@add')->name('add');
    Route::get('/remove/{slug}', 'App\Http\Controllers\CartController@remove')->name('remove');
    Route::get('/cancel', 'App\Http\Controllers\CartController@cancel')->name('cancel');
});

Route::prefix('checkout')->name('checkout.')->group(function(){
    Route::get('/', 'App\Http\Controllers\Checkoutcontroller@index')->name('index');
    Route::post('/proccess', 'App\Http\Controllers\Checkoutcontroller@proccess')->name('proccess');
    Route::get('/thanks', 'App\Http\Controllers\Checkoutcontroller@thanks')->name('thanks');
});

Route::group(['middleware' => ['auth']],function () {

    Route::get('my-orders', 'App\Http\Controllers\UserOrderController@index')->name('user.orders');

    Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function(){
        /*  Route::prefix('stores')->name('stores.')->group(function(){
     
             Route::get('/', 'StoreController@index')->name('index');
             Route::get('/create', 'StoreController@create')->name('create');;
             Route::post('/store', 'StoreController@store')->name('store');;
             Route::get('/{store}/edit', 'StoreController@edit')->name('edit');;
             Route::post('/update/{store}', 'StoreController@update')->name('update');;
             Route::get('/destroy/{store}', 'StoreController@destroy')->name('destroy');;
             
         }); */

         Route::get('notifications', 'NotificationController@notifications')->name('notification.index');
         Route::get('notifications/read-all', 'NotificationController@readAll')->name('notifications.read.all');

         Route::resource('stores', StoreController::class);
         Route::resource('products', ProductController::class);
         Route::resource('categories', CategoryController::class);
         
         Route::post('photos/remove', 'ProductPhotoController@removePhoto')->name('photo.remove');
         
         Route::get('orders/my', 'OrdersController@index')->name('orders.my');
     });
     
});

Auth::routes();


