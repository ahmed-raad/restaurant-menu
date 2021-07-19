<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DishController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/dishes", [DishController::class, "index"]);
Route::get("/dishes/{dish_id}", [DishController::class, "show_dish"]);
Route::post("/dishes", [DishController::class, "store"]);
Route::put("/dishes/{dish_id}", [DishController::class, "update"]);
Route::delete("/dishes/{dish_id}", [DishController::class, "destroy"]);

Route::post('/test', [DishController::class, 'test']);
