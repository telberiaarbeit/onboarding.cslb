<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
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

require __DIR__.'/auth.php';

Route::get('/', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('showLogin');
Route::post('/login', '\App\Http\Controllers\Auth\LoginController@customLogin')->name('login.post'); 
Route::post('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/register', '\App\Http\Controllers\Auth\LoginController@getRegister')->name('get.register');
Route::post('/register', '\App\Http\Controllers\Auth\LoginController@postRegister')->name('post.register');

//Route::group(['middleware' => ['CheckIdAdmin']], function () {
    Route::prefix('users')->group(function () {
        Route::get('/', '\App\Http\Controllers\UsersController@index');
        Route::post('/store', '\App\Http\Controllers\UsersController@store');
        Route::get('/create', '\App\Http\Controllers\UsersController@create');
        Route::get('/edit/{user}', '\App\Http\Controllers\UsersController@edit');
        Route::put('/update/{user}', '\App\Http\Controllers\UsersController@update');
        Route::post('/create-group', '\App\Http\Controllers\UsersController@create_group');
    });
    Route::post('/delete', '\App\Http\Controllers\UsersController@delete_user');
//});
Route::group(['prefix' => 'group-user', 'middleware' => ['auth']], function(){
    Route::get('/', '\App\Http\Controllers\GroupController@index');
    Route::get('/edit/{group_id}', '\App\Http\Controllers\GroupController@edit');
    Route::post('/update/{group_id}', '\App\Http\Controllers\GroupController@update');
    Route::post('/delete-group', '\App\Http\Controllers\GroupController@delete_group');
});
Route::post('/save-group', '\App\Http\Controllers\UsersController@save_group');
Route::post('/load-group-modal', '\App\Http\Controllers\UsersController@load_group_modal');
Route::post('/load-user', '\App\Http\Controllers\UsersController@load_user_group');
Route::post('/open-user-group', '\App\Http\Controllers\UsersController@open_user_group');
Route::post('/open-popup', '\App\Http\Controllers\UsersController@open_popup');
Route::post('/create_new_group', '\App\Http\Controllers\UsersController@create_new_group');

Route::get('/check-deadline', '\App\Http\Controllers\DashboardController@check_deadline');
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth.basic']], function(){
    Route::get('/', '\App\Http\Controllers\DashboardController@list');
    Route::post('/update/', '\App\Http\Controllers\DashboardController@update_task');
});
Route::group(['prefix' => 'boarding-unterlagen', 'middleware' => ['auth.basic']], function(){
    Route::get('/', '\App\Http\Controllers\DashboardController@index');
    Route::get('/create', '\App\Http\Controllers\DashboardController@create')->name('create.checklist');
    Route::post('/store', '\App\Http\Controllers\DashboardController@store')->name('store.checklist');
    Route::post('/update/{id}', '\App\Http\Controllers\DashboardController@update')->name('update.checklist');
    Route::delete('/destroy/{id}', '\App\Http\Controllers\DashboardController@destroy')->name('destroy.checklist');
    Route::get('/edit/{id}', '\App\Http\Controllers\DashboardController@edit')->name('edit.checklist');
});

//route checktask
Route::post('/checktask', '\App\Http\Controllers\UsersController@postCheckTask')->name('post.task');