<?php

use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ManageWalletAccount;
use App\Http\Controllers\UserCommonController;
use Illuminate\Support\Facades\Route;


Route::prefix('user')->group(function () {
    // Manage User
    Route::post('/create', [UserCommonController::class, 'CreateCommonUser']);
    Route::get('/get-users', [UserCommonController::class, 'GetAllCommonUsers']);
    Route::post('/get-user-by-id', [UserCommonController::class, 'GetCommonUserById']);
    Route::post('/delete-user', [UserCommonController::class, 'DeleteCommonUser']);
    // Manage Balance
    Route::post('/add-balance', [ManageWalletAccount::class, 'UserAddBalance']);
    Route::post('/transfer', [ManageWalletAccount::class, 'UserTransfer']);
    Route::get('/get-balance', [ManageWalletAccount::class, 'UserGetBalance']);
});

Route::prefix('manager')->group(function () {
    // Manage User
    Route::get('/get-managers', [ManagerController::class, 'GetAllManagers']);
    Route::post('/create', [ManagerController::class, 'CreateManager']);
    Route::get('/get-manager-by-id', [ManagerController::class, 'GetManagerById']);
    // Manage Balance
    Route::get('/get-balance', [ManageWalletAccount::class, 'VerifyBalance']);
    // Route::post('/add-balance', [ManageWalletAccount::class, 'ManageAddBalance']);
});
