<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Supervisor\SupervisorController;
use App\Http\Controllers\ColorController;


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
});
Route::group(['middleware' => ['role:supervisor'], 'prefix' => 'supervisor'], function () {
    Route::get('/dashboard', [SupervisorController::class, 'index'])->name('supervisor.dashboard');
    Route::delete('/deleteUser/{id}', [UserController::class, 'deleteUser'])->name('supervisor.deleteUser');
    Route::resource('/user', UserController::class);

});


Route::group(['middleware' => ['role:users'], 'prefix' => 'users'], function () {
    Route::get('/dashboard', [UserController::class, 'home'])->name('users.dashboard');
    Route::get('/q1', [UserController::class, 'q1'])->name('users.q1');
    Route::get('/q2', [UserController::class, 'q2'])->name('users.q2');
    Route::post('/storeReqQ1', [UserController::class, 'storeReqQ1']);
    Route::post('/storeReqQ2', [UserController::class, 'storeReqQ2']);
    Route::post('/getData', [UserController::class, 'getData']);

});

Route::get('/count', [UserController::class, 'countShift']);
Route::get('/countPart', [UserController::class, 'countPart']);

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