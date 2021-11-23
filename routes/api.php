<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group(['prefix' => 'admin', 'middleware' => 'throttle:5,1,admin',], function () {
    Route::post('uploadSerialNumber', [ApiController::class , 'uploadSerialNumber']);
   
});
//Route::middleware('auth:api', 'throttle:1,1')->group(function () {
    //dd("fdgdfgd");
/*Route::any('sites', [ApiController::class , 'site']);
Route::any('serialNumber', [ApiController::class , 'getSerialNumber']);
Route::any('serialNumber/update/{id}', [ApiController::class , 'updateSerialNumber']);
Route::delete('serialNumber/delete/{id}', [ApiController::class , 'destroySerialNumber']);*/
//Route::post('uploadSerialNumber', [ApiController::class , 'uploadSerialNumber']);
/*Route::delete('countSerialNumber/delete/{id}', [ApiController::class , 'destroyCountSerialNumber']);
*/
//});




