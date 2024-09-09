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

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['two_factor']], function () {
        Route::get('/', 'AppController@index')->name('siteurl');

        Route::group(['prefix' => 'user-setup', 'as' => 'user-setup.'], function () {

            ///PERMISSIONS
            Route::group(['prefix' => 'permission', 'as' => 'permission.', 'middleware' => 'can:permissions_view'], function () {
                Route::get('get-data', 'PermissionController@ajaxData')->name('get-data');
            });
            Route::resource('permission', 'PermissionController')->middleware('can:permissions_view');
            ///PERMISSIONS

            ///ROLES
            Route::group(['prefix' => 'role', 'as' => 'role.', 'middleware' => 'can:roles_view'], function () {});
            Route::resource('role', 'RoleController')->middleware('can:roles_view');
            ///ROLES

            ///USERS
            Route::group(['prefix' => 'role', 'as' => 'role.', 'middleware' => 'can:users_view'], function () {});
            Route::resource('user', 'UserController')->middleware('can:users_view');
            ///USERS
        });
        Route::get('/listuser', 'UserController@ajaxData')->name('get.user')->middleware('can:view_users');

        //others
        Route::get('get-button-option', 'AjaxController@getButtonOption')->name('get.button-option');
        // Route::post('changepassword', 'AppController@changepassword')->name('changepassword');
    });

    Route::get('2fa', 'TwoFactorController@showTwoFactorForm');
    Route::post('2fa', 'TwoFactorController@verifyTwoFactor')->name('verifyTwoFactor');
});
