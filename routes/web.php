<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\InventoryInController;

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

// Report
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/report/data', [ReportController::class, 'data'])->name('report.data');
Route::get('/report/download', [ReportController::class, 'download'])->name('report.download');

require __DIR__.'/auth.php';
