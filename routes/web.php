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
    return view('auth.login');
})->middleware('guest');


Auth::routes(['verify' => true]);


Route::get('wallet/showvalue', 'WalletController@showvalue')->name('showvalue');
Route::put('/wallet/transfer', 'WalletController@transfer')->name('transfer');
Route::get('export/{month}', 'ExportController@export')->name('export');




Route::put('/pass', 'ChangePassController@postCredentials')->name('pass')->middleware('auth');
Route::group(['prefix' => 'admin','as' => 'admin.','middleware' => 'verified'], function () {
    Route::resource('user', 'UserController');
    Route::resource('wallet', 'WalletController');
    Route::resource('expend', 'ExpendController');
    Route::get('changepass', function(){
        return view('changepass');
    })->name('changepass');

});
