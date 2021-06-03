<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

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
})->name('welcome');

Route::get(
    '/messages',
    [MessageController::class, 'index']
)->name('messages');

Route::get(
    '/new-message',
    [MessageController::class, 'create']
)->name('new-message');

require __DIR__.'/auth.php';
