<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;

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

Route::post('/send-email', [GeneralController::class, 'sendEmail']);
Route::post('/make-request', [GeneralController::class, 'makeRequest']);
Route::post('/save-request', [GeneralController::class, 'saveEmailToNotify']);
