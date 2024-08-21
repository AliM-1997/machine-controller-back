<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MachineInputController;
use App\Http\Controllers\SparePartController;
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
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::apiResource('machineInput', MachineInputController::class);
});

Route::prefix('v1')->group(function(){
    Route::apiResource('machine',MachineController::class);
});

Route::prefix('v1')->group(function(){
Route::apiResource('sparePart',SparePartController::class);
});