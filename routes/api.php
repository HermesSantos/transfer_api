<?php

use App\Http\Controllers\UserCommonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('user')->group(function () {
    Route::post('/create', [UserCommonController::class, 'CreateCommonUser']);
    Route::get('/get-users', [UserCommonController::class, 'GetAllCommonUsers']);
    Route::post('/get-user-by-id', [UserCommonController::class, 'GetCommonUserById']);
});
