<?php

use App\Http\Controllers\User\UserController;
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



Route::get('part-names/{typeId}', [UserController::class, 'getPartNames']);
Route::get('/item-defacts/{typeId}', [UserController::class, 'getItemDefactsByType']);
Route::get('/item-defacts/{item}/{typeId}/{typePart}{namePart}', [UserController::class, 'getData']);