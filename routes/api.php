<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MachineInputController;
use App\Http\Controllers\MachineStatisticController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;

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
    Route::post('machine/uploadImage/{machineId}', [MachineController::class, 'updateMachineImage']);
    Route::get('machine/getImage/{machineId}', [MachineController::class, 'getMachineImage']);
    Route::delete('machine/deleteImage/{machineId}', [MachineController::class, 'deleteMachineImage']);
});

Route::prefix('v1')->group(function(){
    Route::apiResource('sparePart',SparePartController::class)->middleware('auth.admin');
    Route::post('sparePart/uploadImage/{sparePartId}',[SparePartController::class,'updateSparePartImage']);
    Route::get('sparePart/getImage/{sparePartId}',[SparePartController::class,'getSparePartImage']);
    Route::delete('sparePart/deleteImage/{sparePartId}',[SparePartController::class,'deleteSparePartImage']);
});

Route::prefix('v1')->group(function(){
    Route::apiResource('user',UserController::class);
    Route::post('user/updateImage/{userid}',[UserController::class,'updateUserImage']);
    Route::get('user/getImage/{userid}',[UserController::class,"getUserImage"]);
    Route::delete('user/deleteImage/{userid}',[UserController::class,'deleteUserImage']);
});

Route::prefix("v1")->group(function(){
    Route::apiResource('machineStatistic',MachineStatisticController::class);
    Route::get('machineStatistic/machineId/{machineId}',[MachineStatisticController::class,'getStatisticBymachineId']);
    Route::get('machineStatistics/byDate', [MachineStatisticController::class, 'getStatisticByDate']);
});