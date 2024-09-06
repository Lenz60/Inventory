<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', function () {
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware(['auth:admin','verified']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth:admin', 'verified'])->name('dashboard');

Route::middleware('auth:admin')->group(function (){
    Route::get('/input',[InputController::class, 'index'])->name('input.index');
    Route::post('/input',[InputController::class, 'create'])->name('input.create');
    Route::patch('/input',[InputController::class, 'update'])->name('input.update');
    Route::delete('/input',[InputController::class, 'delete'])->name('input.delete');
    Route::delete('/input/bulk',[InputController::class, 'deleteBulk'])->name('input.bulkdelete');

    // Route::get('/import',[InputController::class, 'importIndex'])->name('input.importIndex');
    Route::post('/import',[InputController::class, 'import'])->name('input.import');
});

Route::middleware('auth:admin')->group(function(){
    Route::get('/manage', [AdminController::class, 'manageIndex'])->name('manage.index');
    Route::post('/manage', [AdminController::class, 'manageCreate'])->name('manage.create');
    Route::delete('/manage', [AdminController::class, 'manageDelete'])->name('manage.delete');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth:admin')->group(function (){
    Route::get('/order-manage',[OrderController::class, 'index'])->name('order.index');
    Route::patch('/order-manage/update',[OrderController::class, 'update'])->name('order.update');
    Route::post('/order-manage/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
});

Route::middleware('auth:admin')->group(function (){
    Route::get('/device',[DeviceController::class, 'index'])->name('device.index');
});

require __DIR__.'/auth.php';
