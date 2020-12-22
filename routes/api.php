<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\SuperheroesController;




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



Route::get('/superheroes/', [SuperheroesController::class, 'index']);
Route::get('/superheroes/create-data', [SuperheroesController::class, 'createData']);
Route::get('/superheroes/{id}', [SuperheroesController::class, 'show']);
Route::put('/superheroes/{id}', [SuperheroesController::class, 'update']);
Route::delete('/superheroes/{id}', [SuperheroesController::class, 'destroy']);
Route::post('/superheroes', [SuperheroesController::class, 'store']);

Route::get('/favorite-superheroes', [SuperheroesController::class, 'getAll']);
Route::put('/favorite-superheroes', [SuperheroesController::class, 'setFavorites']);
