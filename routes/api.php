<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\Api\Auth\JWTAuthController;

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


Route::prefix('/auth/')->group(function () { 
	Route::post('/login', [JWTAuthController::class, 'login']);
	Route::post('/register', [JWTAuthController::class, 'register']);

	Route::post('/me', [JWTAuthController::class, 'me']);
	Route::post('/refresh', [JWTAuthController::class, 'refresh']);
	Route::post('/logout', [JWTAuthController::class, 'logout']);
});

// Route::group([
//     'prefix' => 'auth'
// ], function (){
//     Route::post('login', 'Api\Auth\JWTAuthController@login')->name('jwt.login');
//     Route::post('register', 'Api\Auth\JWTAuthController@register')->name('jwt.register');

    // Route::post('me', 'Api\Auth\JWTAuthController@me')->name('jwt.me');
    // Route::post('refresh', 'Api\Auth\JWTAuthController@refresh')->name('jwt.refresh');
    // Route::post('logout', 'Api\Auth\JWTAuthController@register')->name('jwt.logout');

//});

Route::prefix('/v1/')->group(function () { 
 //	Route::apiResource('todos', 'TodoController');
Route::get('/todos', [TodoController::class, 'index']);
Route::get('/todos/{id}', [TodoController::class, 'show']);
Route::post('/todos', [TodoController::class, 'store']);
Route::put('/todos/{todo}', [TodoController::class, 'update']);
Route::delete('/todos/{id}', [TodoController::class, 'destroy']);
});

//Route::get('/todos', 'TodoController@index')->name('todo.index');
// Route::get('/todos', [TodoController::class, 'index']);
// Route::get('/todos/{id}', [TodoController::class, 'show']);
// Route::post('/todos', [TodoController::class, 'store']);
// Route::put('/todos/{todo}', [TodoController::class, 'update']);
// Route::delete('/todos/{id}', [TodoController::class, 'destroy']);

//Route::apiResource( name 'todos', controller: 'TodoController');