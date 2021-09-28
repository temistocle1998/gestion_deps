<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/depense', [DepenseController::class, 'store']);
    Route::get('/depense', [DepenseController::class, 'getDepenseByUser']);
    Route::get('/depense-actuel', [DepenseController::class, 'getTotalCurrentDepense']);
    Route::resource('/revenu', RevenuController::class);
    Route::get('/currentRevenu', 'RevenuController@revenuActuel');
    Route::get('/AllRevenuByUser', 'RevenuController@AllRevenuByUser');
    Route::get('/revenuMois', 'RevenuController@revenuMois');

});

Route::resource('/categorie', CategorieController::class);
Route::get('/getNombreCategorie', 'CategorieController@getNombreCategorie');
Route::get('/getTypeRevenu', 'RevenuController@getTypeRevenu');
