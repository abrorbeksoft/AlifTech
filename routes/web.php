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

Route::get('/', [\App\Http\Controllers\PagerController::class,'index'])->name('home');
Route::resource('contact',\App\Http\Controllers\ContactController::class);
Route::resource('number',\App\Http\Controllers\NumberController::class);
Route::resource('email',\App\Http\Controllers\EmailController::class);
Route::resource('image',\App\Http\Controllers\ImageController::class);

