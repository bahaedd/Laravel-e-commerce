<?php

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

require 'admin.php';

Route::view('/', 'site.pages.homepage');
// social login
Route::get('redirect/{driver}', 'Auth\LoginController@redirectToProvider')
    ->name('login.provider')
    ->where('driver', implode('|', config('auth.socialite.drivers')));
Route::get('{driver}/callback', 'Auth\LoginController@handleProviderCallback')
    ->name('login.callback')
    ->where('driver', implode('|', config('auth.socialite.drivers')));


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/category/{slug}', 'Site\CategoryController@show')->name('category.show');

Route::get('/product/{slug}', 'Site\ProductController@show')->name('product.show');

Route::post('/product/add/cart', 'Site\ProductController@addToCart')->name('product.add.cart');
Route::get('/cart', 'Site\CartController@getCart')->name('checkout.cart');
Route::get('/cart/item/{id}/remove', 'Site\CartController@removeItem')->name('checkout.cart.remove');
Route::get('/cart/clear', 'Site\CartController@clearCart')->name('checkout.cart.clear');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/checkout', 'Site\CheckoutController@getCheckout')->name('checkout.index');
    Route::post('/checkout/order', 'Site\CheckoutController@placeOrder')->name('checkout.place.order');
});

Route::get('checkout/payment/complete', 'Site\CheckoutController@complete')->name('checkout.payment.complete');
Route::get('account/orders', 'Site\AccountController@getOrders')->name('account.orders');

Route::group(['prefix' => 'orders'], function () {
    Route::get('/', 'Admin\OrderController@index')->name('admin.orders.index');
    Route::get('/{order}/show', 'Admin\OrderController@show')->name('admin.orders.show');
 });
