<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CategoriyTagController;
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

Route::post('/user/login', [LoginController::class, 'login']);
Route::post('/user/logout', [LoginController::class, 'logout']);
Route::post('/user/sing_up', [RegisterController::class, 'create']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/auth', [LoginController::class, 'auth']);
    Route::get('/get_all', [RestaurantController::class, 'getAll'])->middleware('auth');
    Route::apiResource('/gourmet', RestaurantController::class)->middleware('auth');
    Route::apiResource('/categorie', CategorieController::class)->middleware('auth');
    Route::apiResource('/category_tag', CategoriyTagController::class)->middleware('auth');

    Route::post('/updata/{id}', [RestaurantController::class, 'updated']);
});
