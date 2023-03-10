<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['json.response']], function () {
    Route::post('/login', [App\Http\Controllers\Auth\UserAuthController::class, 'loginApi'])->name('login.api');
});

Route::group(['middleware' => ['auth:sanctum', 'json.response']], function () {
	Route::get('organizations', [OrganizationController::class, 'index']);
	Route::post('organizations', [OrganizationController::class, 'store']);
});
