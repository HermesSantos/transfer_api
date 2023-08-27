<?php

use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ManageWalletAccount;
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
    Route::post('/delete-user', [UserCommonController::class, 'DeleteCommonUser']);
    Route::post('/add-balance', [ManageWalletAccount::class, 'UserAddBalance']);
});
Route::prefix('manager')->group(function () {
    Route::get('/get-managers', [ManagerController::class, 'GetAllManagers']);
    Route::post('/create', [ManagerController::class, 'CreateManager']);
    Route::get('/get-manager-by-id', [ManagerController::class, 'GetManagerById']);
    Route::post('/add-balance', [ManageWalletAccount::class, 'ManagerAddBalance']);
});
