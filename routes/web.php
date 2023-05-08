<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Log;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'index']);

Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [LoginController::class, 'register']);

Route::post('/register', [LoginController::class, 'store']);

Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/dash', [DashboardController::class, 'index']);

Route::get('/shop', [ShopController::class, 'index']);

Route::get('/shop/add', [ShopController::class, 'create']);

Route::post('/shop/add', [ShopController::class, 'store']);

Route::get('/shop/edit/{id}', [ShopController::class, 'edit']);

Route::put('/shop/edit/{id}', [ShopController::class, 'update']);

Route::delete('/shop/delete/{id}', [ShopController::class, 'destroy']);

Route::get('/shop/{id}', [ShopController::class, 'show']);

Route::get('/shops/detail', [ShopController::class, 'shop_admin']);

Route::put('/shops/edit/admin/{id}', [ShopController::class, 'update_admin']);

Route::get('/product', [ProductController::class, 'index']);

Route::get('/product/add/{id}', [ProductController::class, 'create']);

Route::post('/product/add', [ProductController::class, 'store']);

Route::get('/product/edit/{id}', [ProductController::class, 'edit']);

Route::patch('/product/edit/{id}', [ProductController::class, 'update']);

Route::delete('/product/delete/{id}', [ProductController::class, 'destroy']);

Route::get('/product/addstock/{id}', [ProductController::class, 'editstock']);

Route::patch('/product/addstock/{id}', [ProductController::class, 'updatestock']);

Route::get('/user/profile', [UserController::class, 'index']);

Route::get('/user/profile/edit', [UserController::class, 'edit']);

Route::patch('/user/profile/edit', [UserController::class, 'update']);

Route::get('/user', [UserController::class, 'list']);

Route::get('/user/addadmin', [UserController::class, 'create']);

Route::post('/user/addadmin', [UserController::class, 'store']);

Route::get('/user/edit/{id}', [UserController::class, 'edit_sa']);

Route::patch('/user/edit/{id}', [UserController::class, 'update_sa']);

Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);

Route::get('/user/admin', [UserController::class, 'list_admin']);

Route::get('/user/addemployee/{id}', [UserController::class, 'create_em']);

Route::post('/user/addemployee', [UserController::class, 'store_em']);

Route::get('/user/editemployee/{id}', [UserController::class, 'edit_em']);

Route::patch('/user/editemployee/{id}', [UserController::class, 'update_em']);

Route::delete('/user/deleteemployee/{id}', [UserController::class, 'destroy_em']);