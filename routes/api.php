<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeveloperController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('developers', [DeveloperController::class, 'store'])->name('developer.store');

Route::get('developers', [DeveloperController::class, 'index'])->name('developer.index');
Route::put('developers/{developer}', [DeveloperController::class, 'update'])->name('developer.update');
Route::delete('developers/{developer}', [DeveloperController::class, 'destroy'])->name('developer.destroy');
