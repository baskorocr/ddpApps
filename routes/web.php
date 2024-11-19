<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Supervisor\SupervisorController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TypePartController;
use App\Http\Controllers\TypeDefectController;
use App\Http\Controllers\ItemDefactController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\reports;

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


Route::get('/', [Controller::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('colors', ColorController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('type_defects', TypeDefectController::class);
    Route::resource('type_parts', TypePartController::class);
    Route::resource('shifts', ShiftController::class);
    Route::resource('lines', LineController::class);
    Route::resource('parts', PartController::class);
    Route::resource('item_defacts', ItemDefactController::class);



});
Route::group(['middleware' => ['role:supervisor'], 'prefix' => 'supervisor'], function () {
    Route::get('/dashboard', [SupervisorController::class, 'index'])->name('supervisor.dashboard');
    Route::delete('/deleteUser/{id}', [UserController::class, 'deleteUser'])->name('supervisor.deleteUser');
    Route::resource('/user', UserController::class);

});




Route::get('/reports', [reports::class, 'filterData'])->name('reports.index');
Route::get('/reports/export', [reports::class, 'exportData'])->name('reports.export');
Route::group(['middleware' => ['role:users'], 'prefix' => 'users'], function () {
    Route::get('/dashboard', [UserController::class, 'home'])->name('users.dashboard');
    Route::get('/q1', [ProsesController::class, 'q1'])->name('users.q1');
    Route::get('/q2', [ProsesController::class, 'q2'])->name('users.q2');
    Route::post('/storeReqQ1', [ProsesController::class, 'storeReqQ1']);
    Route::post('/storeReqQ2', [ProsesController::class, 'storeReqQ2']);
    Route::post('/getData', [ProsesController::class, 'getData']);

});

Route::get('/count', [ProsesController::class, 'countShift']);
Route::get('/countPart', [ProsesController::class, 'countPart'])->name('count-parts');

// // useless routes
// // Just to demo sidebar dropdown links active states.
// Route::get('/buttons/text', function () {
//     return view('buttons-showcase.text');
// })->middleware(['auth'])->name('buttons.text');

// Route::get('/buttons/icon', function () {
//     return view('buttons-showcase.icon');
// })->middleware(['auth'])->name('buttons.icon');

// Route::get('/buttons/text-icon', function () {
//     return view('buttons-showcase.text-icon');
// })->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';