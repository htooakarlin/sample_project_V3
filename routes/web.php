<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustomerController;

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
//     return view('welcome');
// });

Route::controller(CarController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/cars', 'index')->name('cars.list');
    Route::get('/cars/{id}/purchases', 'getPurchases');

    Route::view('/cars/create', 'cars.create')->name('cars.create');
    Route::post('cars/create', 'store');

    Route::get('/cars/edit/{id}', 'edit');
    Route::post('/cars/edit/{id}', 'update');

    Route::get('/cars/delete/{id}', 'delete');
});

// ------------------------------------------------------------------------------------

Route::controller(CustomerController::class)->group(function (){
    Route::get('/users', 'index')->name('users.list');
    Route::get('/users/{id}/purchases', 'getPurchases');
    
    Route::get('/users/create', 'create');
    Route::post('/users/create', 'store');

    Route::get('/users/edit/{id}', 'edit');
    Route::post('/users/edit/{id}', 'update');

    Route::get('/users/delete/{id}', 'delete');

    //------------------------------------------------------------------------------

    Route::get('/users/{id}/buyCar', 'buyCar');
    Route::get('/users/{id}/buyCar/{cid}', 'buyCarStore');

    Route::get('/users/{id}/ownCar/edit', 'ownerCarEdit');
    Route::get('/users/{id}/ownCar/edit/delete/{cid}', 'ownerCarDelete');
});