<?php

use App\Http\Controllers\Module1Controller;
use App\Http\Controllers\Module2Controller;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('module1', Module1Controller::class);
    Route::resource('module2', Module2Controller::class);
});
Route::group(['middleware' => ['auth','permission:user-edit|user-delete']], function () {

    Route::controller(UserController::class)->group(function () {
        Route::post('user', 'loadData')->name('user.loadData');
        Route::post('user-store', 'store')->name('user.store');
        Route::get('user-form', 'create');
        Route::get('edituser/{id}', 'edit');
        Route::post('deleteuser', 'destroy')->name('user.destroy');
        Route::post('updateuser', 'update')->name('user.update');
        Route::post('getpermission', 'getpermission')->name('user.getpermission');
    });
});
Route::group(['middleware' => ['auth','permission:module1-view']], function () {

    Route::controller(Module1Controller::class)->group(function () {
        Route::post('module1', 'loadData')->name('module1.loadData');
    });

});
Route::group(['middleware' => ['auth','permission:module2-view']], function () {

    Route::controller(Module2Controller::class)->group(function () {
        Route::post('module2', 'loadData')->middleware('can:module2-view')->name('module2.loadData');
    });
});
Route::group(['middleware' => ['auth','permission:role-edit|role-delete']], function () {

    Route::controller(RoleController::class)->group(function () {
        Route::post('role', 'loadData')->name('role.loadData');
        Route::get('role-form', 'create');
        Route::post('role-store', 'store')->name('role.store');
        Route::post('deleterole', 'destroy')->name('role.destroy');
        Route::get('editrole/{id}', 'edit');
        Route::post('updaterole', 'update')->name('role.update');
    });
});