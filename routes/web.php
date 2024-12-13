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

Route::get('/',  [CarController::class, 'index']);
Route::get('/cars', [CarController::class, 'index'])->name('cars.list');

// Route::view('/cars/create', 'cars/create');
Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
Route::post('/cars/create', [CarController::class, 'store']);

Route::get('/cars/edit/{id}', [CarController::class, 'edit']);
Route::post('/cars/edit/{id}', [CarController::class, 'update']);

Route::get('/cars/delete/{id}', [CarController::class, 'delete']);

// ------------------------------------------------------------------------------------

Route::get('/users', [CustomerController::class, 'index'])->name('users.list');

Route::get('/users/create', [CustomerController::class, 'create']);
Route::post('/users/create', [CustomerController::class, 'store']);

Route::get('/users/edit/{id}', [CustomerController::class, 'edit']);
Route::post('/users/edit/{id}', [CustomerController::class, 'update']);

Route::get('/users/delete/{id}', [CustomerController::class, 'delete']);

// ------------------------------------------------------------------------------------

Route::get('/cars/{id}/purchases', [CarController::class, 'getPurchases']);

Route::get('/users/{id}/purchases', [CustomerController::class, 'getPurchases']);
Route::get('/users/{id}/buyCar', [CustomerController::class, 'buyCar']);
Route::get('/users/{id}/buyCar/{cid}', [CustomerController::class, 'buyCarStore']);
Route::get('/users/{id}/ownCar/edit', [CustomerController::class, 'ownerCarEdit']);
Route::get('/users/{id}/ownCar/edit/delete/{cid}', [CustomerController::class, 'ownerCarDelete']);