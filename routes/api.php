<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('index', [DemoController::class, 'index'])->name('index');


Route::get('users_list', [UsersController::class, 'users_list'])->name('users_list');
Route::get('single_user/{user_id}', [UsersController::class, 'single_user'])->name('single_user');
Route::post('store_users', [UsersController::class, 'store_users'])->name('store_users');
Route::put('update_user/{user_id}', [UsersController::class, 'update_user'])->name('update_user');
Route::delete('delete_user/{user_id}', [UsersController::class, 'delete_user'])->name('delete_user');

Route::post('upload_image', [UsersController::class, 'upload_image'])->name('upload_image');
