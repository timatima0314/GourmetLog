<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\RestaurantController;
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

Route::apiResource('/gourmet', RestaurantController::class);
Route::apiResource('/categorie', CategorieController::class);

Route::post('/updata/{id}', [RestaurantController::class, 'updated']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
