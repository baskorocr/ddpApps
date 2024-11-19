<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ProsesController;
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



Route::get('part-names/{typeId}', [ProsesController::class, 'getPartNames'])->name('part-names');
Route::get('/item-defacts/{typeId}', [ProsesController::class, 'getItemDefactsByType']);
Route::get('/item-defacts/{item}/{typeId}/{typePart}{namePart}', [ProsesController::class, 'getData']);