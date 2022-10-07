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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('chat')->middleware("auth")->name('chat.')->group(function(){
    Route::get('/', [App\Http\Controllers\ChatController::class, 'index'])->name('index');
    Route::post('/message', [App\Http\Controllers\ChatController::class, 'messageRecieved'])->name('message');
    Route::get('/greet/{user}',[App\Http\Controllers\ChatController::class, 'greetReceived'])->name('greet');
});
