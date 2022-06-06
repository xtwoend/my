<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\NoGoodController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotGoodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\InventoryInController;
use App\Http\Controllers\ProductReturnController;
use App\Http\Controllers\RecapitulationController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group([
    'middleware' => 'auth'
], function(){

    // Product
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product/data', [ProductController::class, 'data'])->name('product.data');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'remove'])->name('product.remove');
    Route::get('/product/download', [ProductController::class, 'download'])->name('product.download');
    Route::post('/product/send-mqtt', [ProductController::class, 'sendToMQTT'])->name('product.send-mqtt');

    // Shift
    Route::get('/shift', [ShiftController::class, 'index'])->name('shift');
    Route::get('/shift/data', [ShiftController::class, 'data'])->name('shift.data');
    Route::post('/shift/store', [ShiftController::class, 'store'])->name('shift.store');
    Route::post('/shift/{id}', [ShiftController::class, 'update'])->name('shift.update');
    Route::delete('/shift/{id}', [ShiftController::class, 'remove'])->name('shift.remove');

    // Location
    Route::get('/location', [LocationController::class, 'index'])->name('location');
    Route::get('/location/data', [LocationController::class, 'data'])->name('location.data');
    Route::post('/location/store', [LocationController::class, 'store'])->name('location.store');
    Route::put('/location/{id}', [LocationController::class, 'update'])->name('location.update');
    Route::delete('/location/{id}', [LocationController::class, 'remove'])->name('location.remove');

    // Sync To SAP
    Route::get('/sync', [SyncController::class, 'index'])->name('sync');
    Route::post('/sync', [SyncController::class, 'sync'])->name('sync.store');
    Route::get('/sync/log', [SyncController::class, 'log'])->name('sync.log');
});

// Inventory In
Route::get('/line-in', [InventoryInController::class, 'index'])->name('line-in');
Route::get('/line-in/data', [InventoryInController::class, 'data'])->name('line-in.data');

// Schedule
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
Route::get('/schedule/data', [ScheduleController::class, 'data'])->name('schedule.data');
Route::get('/schedule/active', [ScheduleController::class, 'active'])->name('schedule.active');
Route::get('/schedule/dropdown', [ScheduleController::class, 'dropdown'])->name('schedule.dropdown');

// Rekapitulasi
Route::get('/recapitulation', [RecapitulationController::class, 'index'])->name('recapitulation');
Route::get('/recapitulation/pallet', [RecapitulationController::class, 'pallet'])->name('recapitulation.pallet');
Route::post('/recapitulation', [RecapitulationController::class, 'create'])->name('recapitulation.create');
Route::delete('/pallet/{id}', [RecapitulationController::class, 'destroy'])->name('pallet.destroy');
Route::put('/pallet/{id}', [RecapitulationController::class, 'update'])->name('pallet.update');

// Product Return
Route::post('/product/return', [ProductReturnController::class, 'store'])->name('product.return');
Route::delete('/product/return/{id}', [ProductReturnController::class, 'destory'])->name('product.return.destory');
Route::get('/product/return/data', [ProductReturnController::class, 'data'])->name('product.return.data');


// Report
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/report/data', [ReportController::class, 'data'])->name('report.data');
Route::get('/report/print', [ReportController::class, 'print'])->name('report.print');
Route::get('/report/download', [ReportController::class, 'download'])->name('report.download');

Route::get('/reason/dropdown', [ReasonController::class, 'dropdown'])->name('reason.dropdown');
Route::get('/reason', [ReasonController::class, 'index'])->name('reason');
Route::get('/reason/data', [ReasonController::class, 'data'])->name('reason.data');
Route::post('/reason', [ReasonController::class, 'store'])->name('reason.store');
Route::delete('/reason/{id}', [ReasonController::class, 'destroy'])->name('reason.destroy');
Route::put('/reason/{id}', [ReasonController::class, 'update'])->name('reason.update');

// Ajax request
Route::group([
    'prefix' => 'ajax'
], function(){
    Route::post('/product', [\App\Http\Controllers\Api\ProductController::class, 'find'])->name('ajax.product.find');
});

require __DIR__.'/auth.php';
