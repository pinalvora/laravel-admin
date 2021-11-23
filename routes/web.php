<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\SerialNumberController; 
use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Admin\SerialNumberValidateController;
use App\Http\Controllers\SaleController; 

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
    return view('auth.login');
});
//Route::group(['middleware' => 'revalidate'],function(){
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
//Route::group(['prefix' => 'admin', 'middleware'=>'auth'], function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('dashboard/list',[DashboardController::class,'list'])->name('dashboard/list');

    Route::resource('/sites', SiteController::class);
    Route::get('getsite', [SiteController::class, 'getSite'])->name('getsite');
    Route::get('sitelist', [SiteController::class, 'siteList'])->name('sitelist');
    Route::get('checksite', [SiteController::class, 'checkSite'])->name('checksite');


    Route::get('importExportView', [SerialNumberController::class, 'importExportView'])->name('importExportView');
    Route::get('export', [SerialNumberController::class, 'export'])->name('export');
    Route::post('import', [SerialNumberController::class, 'import'])->name('import');
    Route::get('getserialnumbers', [SerialNumberController::class, 'getFile'])->name('getserialnumbers');
    Route::get('getserialnumbers/edit/{id}', [SerialNumberController::class, 'edit'])->name('getserialnumbers/edit');
    Route::post('getserialnumbers/update', [SerialNumberController::class, 'update'])->name('getserialnumbers/update');
    Route::get('import/getsitelist', [SerialNumberController::class, 'getSiteList'])->name('import/getsitelist');
    Route::delete('import/delete', [SerialNumberController::class, 'destroy'])->name('import/delete');

    Route::get('activeSerialNumber', [SerialNumberValidateController::class, 'list'])->name('activeSerialNumber');
    Route::get('getserialnumberlist', [SerialNumberValidateController::class, 'getSerialNumberList'])->name('getserialnumberlist');
    Route::get('checkSerialNumber', [SerialNumberValidateController::class, 'index'])->name('checkSerialNumber');
    Route::post('checkSerialNumber/save', [SerialNumberValidateController::class, 'store'])->name('checkSerialNumber/save');
    Route::delete('checkSerialNumber/delete', [SerialNumberValidateController::class, 'destroy'])->name('checkSerialNumber/delete');
    Route::get('checkSerialNumber/show/{id}', [SerialNumberValidateController::class, 'show'])->name('checkSerialNumber/show');
    Route::get('getLogData', [SerialNumberValidateController::class, 'getLogList'])->name('getLogData');
    Route::get('email-test', function(){
        $details['email'] = 'pinalvora2398@gmail.com';
        dispatch(new App\Jobs\SendEmailJob($details));
        dd('done');
    });
    Route::get('/sales', [SaleController::class,'index'])->name('upload');
    Route::post('/sales', [SaleController::class,'upload_csv_records']);

//});
});