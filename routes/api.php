<?php

use App\Events\NotificationCountEvent;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GPTController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MachineInputController;
use App\Http\Controllers\MachineSparePartController;
use App\Http\Controllers\MachineStatisticController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotficationController;
use App\Http\Controllers\NotificationController;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\SensorDataController;
use Illuminate\Support\Facades\Auth;

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
    Route::post('v1/login', 'login')->name('login');
    Route::post('v1/register', 'register');
    Route::post('v1/logout', 'logout');     
    Route::post('v1/refresh', 'refresh');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('auth.admin')->group(function () {
    Route::apiResource('machineInput', MachineInputController::class);
});

Route::prefix('v1')->middleware('auth.admin')->group(function(){
    Route::apiResource('machine',MachineController::class);
    Route::get('machine/name/{name}', [MachineController::class, 'GetByMachineName']);
    Route::post('machine/uploadImage/{machineId}', [MachineController::class, 'updateMachineImage']);
    Route::get('machine/getImage/{machineId}', [MachineController::class, 'getMachineImage']);
    Route::delete('machine/deleteImage/{machineId}', [MachineController::class, 'deleteMachineImage']);
    Route::patch('/machines/addsparepart/{serialnumber}', [MachineController::class, 'addSparePartToMachine']);
    
    
});
Route::prefix('v1')->middleware('auth.user')->group(function(){
    Route::get('machine/all/name', [MachineController::class, 'getAllName']);
    Route::get('machine/serial/number', [MachineController::class, 'getSerialNumbers']);
    Route::get('user/all/username',[UserController::class,'getAllUserNames']);
    Route::get('sparePart/serial/numbers',[SparePartController::class,'getAllSerialNumbers']);
});

Route::prefix('v1')->middleware('auth.admin')->group(function(){
    Route::apiResource('sparePart',SparePartController::class);
    Route::post('sparePart/uploadImage/{sparePartId}',[SparePartController::class,'updateSparePartImage']);
    Route::get('sparePart/getImage/{sparePartId}',[SparePartController::class,'getSparePartImage']);
    Route::delete('sparePart/deleteImage/{sparePartId}',[SparePartController::class,'deleteSparePartImage']);
    Route::get('sparePart/type/{type}',[SparePartController::class,'getbytype']);
});

Route::prefix('v1')->middleware('auth.admin')->group(function(){
    Route::apiResource('user',UserController::class);
    Route::post('user/updateImage/{userid}',[UserController::class,'updateUserImage']);
    Route::get('user/getImage/{userid}',[UserController::class,"getUserImage"]);
    Route::delete('user/deleteImage/{userid}',[UserController::class,'deleteUserImage']);
});

Route::prefix("v1")->middleware('auth.admin')->group(function(){
    Route::apiResource('machineStatistic',MachineStatisticController::class);
    Route::get('machineStatistics/machineId/{machineId}',[MachineStatisticController::class,'getStatisticBymachineId']);
    Route::get('machineStatistics/byDate', [MachineStatisticController::class, 'getStatisticByDate']);
    Route::get('machineStatistics/comparison', [MachineStatisticController::class, 'getStatisticsForMachinesComparison']);
    Route::get('machineStatistics/{name}', [MachineStatisticController::class, 'getStatisticByName']);
    Route::get('machineStatistics/byName/byDate', [MachineStatisticController::class, 'getStatisticByDateAndMachine']);
    Route::get('machineStatistics/byName/betweenDate', [MachineStatisticController::class, 'getStatisticByNameAndBetweenDate']);
    Route::post('machineStatistics/calculations',[MachineStatisticController::class,"StatisticCalculations"]);
    
});

Route::prefix('v1')->middleware('auth.user')->group(function() {
    Route::apiResource('task', TaskController::class);
    Route::get('task/machinename/{name}', [TaskController::class, 'getTaskByMachineName'])->middleware('auth.admin');
    Route::get('task/machineserialnumber/{serialnumber}', [TaskController::class, 'getTaskByMachinSerialNumber']);
    Route::get('task/status/{status}', [TaskController::class, 'getTaskBystatus'])->middleware('auth.admin');
    Route::get('task/date/{date}', [TaskController::class, 'getTaskByDate'])->middleware('auth.admin');
    Route::get('task/username/{username}', [TaskController::class, 'getTaskByEmployee']);
    Route::post('task/username', [TaskController::class, 'createTaskByUsername']);
    Route::get('task/all/details', [TaskController::class, 'getAllTasksWithDetails']);
    Route::get('task/all/details/{taskId}', [TaskController::class, 'getTaskWithDetails']);
    Route::post('task/user/report/{taskId}', [TaskController::class, 'addTaskReport']);
});


Route::prefix('v1')->middleware('auth.user')->group(function () {
    Route::get('notifications', [NotificationController::class, 'getAllNotifications']);
    Route::patch('notifications/{notificationId}/read', [NotificationController::class, 'markNotificationAsRead']);
    Route::get('notifications/unread', [NotificationController::class, 'getUnreadNotifications']);
});

Route::post('/generate-text', [GPTController::class, 'generateText']);

Route::prefix('v1')->middleware('auth.admin')->group(function () {
    Route::post('/machines/spareparts/create', [MachineSparePartController::class, 'create']);
    Route::post('/machine-spare-part/relationship', [MachineSparePartController::class, 'getRelationship']);
    Route::post('machine/spareparts/get', [MachineSparePartController::class, 'getSparePartsByMachine']);

});
Route::prefix('v1')->middleware('auth.admin')->group(function () {
    Route::post('/sensordata', [SensorDataController::class, 'store']);
    Route::get('/sensordata/last', [SensorDataController::class, 'getsensordata']);
});




