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

Auth::routes(['register'=>false]);

Route::get('user/login','App\Http\Controllers\FrontendController@login')->name('login.form');
Route::post('user/login','App\Http\Controllers\FrontendController@loginSubmit')->name('login.submit');
Route::get('user/logout','App\Http\Controllers\FrontendController@logout')->name('user.logout');

Route::get('user/register','App\Http\Controllers\FrontendController@register')->name('register.form');
Route::post('user/register','App\Http\Controllers\FrontendController@registerSubmit')->name('register.submit');
// Reset password
Route::post('password-reset', 'App\Http\Controllers\FrontendController@showResetForm')->name('password.reset');

Route::get('/','App\Http\Controllers\FrontendController@home')->name('home');

// Frontend Routes
Route::get('/home', 'App\Http\Controllers\FrontendController@index');
Route::get('/about-us','App\Http\Controllers\FrontendController@aboutUs')->name('about-us');
Route::get('product-detail/{id}','App\Http\Controllers\FrontendController@productDetail')->name('product-detail');
Route::post('/product/search','App\Http\Controllers\FrontendController@productSearch')->name('product.search');
// Cart section
Route::get('/add-to-cart/{id}','App\Http\Controllers\CartController@addToCart')->name('add-to-cart')->middleware('user');
Route::post('/add-to-cart','App\Http\Controllers\CartController@singleAddToCart')->name('single-add-to-cart')->middleware('user');
Route::get('cart-delete/{id}','App\Http\Controllers\CartController@cartDelete')->name('cart-delete');
Route::post('cart-update','App\Http\Controllers\CartController@cartUpdate')->name('cart.update');

Route::get('/cart',function(){
    return view('frontend.pages.cart');
})->name('cart');
Route::get('/checkout','App\Http\Controllers\CartController@checkout')->name('checkout')->middleware('user');
Route::post('cart/order','App\Http\Controllers\OrderController@store')->name('cart.order');
Route::get('order/pdf/{id}','App\Http\Controllers\OrderController@pdf')->name('order.pdf');
Route::get('/income','App\Http\Controllers\OrderController@incomeChart')->name('product.order.income');
// Route::get('/user/chart','AdminController@userPieChart')->name('user.piechart');
Route::get('/product-grids','App\Http\Controllers\FrontendController@productGrids')->name('product-grids');
Route::get('/product-lists','App\Http\Controllers\FrontendController@productLists')->name('product-lists');
Route::match(['get','post'],'/filter','App\Http\Controllers\FrontendController@productFilter')->name('shop.filter');
// Order Track
Route::get('/product/track','App\Http\Controllers\OrderController@orderTrack')->name('order.track');
Route::post('product/track/order','App\Http\Controllers\OrderController@productTrackOrder')->name('product.track.order')->middleware('auth');



// Backend section start

Route::group(['prefix'=>'/admin','middleware'=>['auth','admin']],function(){
    Route::get('/','App\Http\Controllers\AdminController@index')->name('admin');
    Route::get('/file-manager',function(){
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    // user route
    Route::resource('users','App\Http\Controllers\UsersController');
    // Profile
    Route::get('/profile','App\Http\Controllers\AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}','App\Http\Controllers\AdminController@profileUpdate')->name('profile-update');
    // Product
    Route::resource('/product','App\Http\Controllers\ProductController');
    // Order
    Route::resource('/order','App\Http\Controllers\OrderController');
    // Settings
    Route::get('settings','App\Http\Controllers\AdminController@settings')->name('settings');
    Route::post('setting/update','App\Http\Controllers\AdminController@settingsUpdate')->name('settings.update');
    // Password Change
    Route::get('change-password', 'App\Http\Controllers\AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'App\Http\Controllers\AdminController@changPasswordStore')->name('change.password');
});

// User section start
Route::group(['prefix'=>'/user','middleware'=>['user']],function(){
    Route::get('/','App\Http\Controllers\HomeController@index')->name('user');
     // Profile
     Route::get('/profile','App\Http\Controllers\HomeController@profile')->name('user-profile');
     Route::post('/profile/{id}','App\Http\Controllers\HomeController@profileUpdate')->name('user-profile-update');
    //  Order
    Route::get('/order',"App\Http\Controllers\HomeController@orderIndex")->name('user.order.index');
    Route::get('/order/show/{id}',"App\Http\Controllers\HomeController@orderShow")->name('user.order.show');
    Route::delete('/order/delete/{id}','App\Http\Controllers\HomeController@userOrderDelete')->name('user.order.delete');

    // Password Change
    Route::get('change-password', 'App\Http\Controllers\HomeController@changePassword')->name('user.change.password.form');
    Route::post('change-password', 'App\Http\Controllers\HomeController@changPasswordStore')->name('change.password');

});
