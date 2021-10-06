<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepenseController;
use App\Http\Middleware\CORS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
header('Access-Control-Allow-Origin: https://gestion-depense-angular.herokuapp.com');
header('Access-Control-Allow-Headers: Accept, Origin, Authorization, X-Requested-Withn, NT,X-CustomHeader,Keep-Alive,User-Agent,If-Modified-Since,Cache-Control,Content-Type,Content-Range,Range');
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
    'middleware' => ['api', 'cors'],
    'prefix' => 'auth'

], function ($router) {
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
Route::get('/getDepenseByYear/{year}', 'DepenseController@getDepenseByYear');
// Route::middleware([CORS::class]
// )->group(function () {
//     Route::post('/auth/login', [AuthController::class, 'login']);
//     Route::post('/auth/register', [AuthController::class, 'register']);
//     Route::post('/auth/logout', [AuthController::class, 'logout']);
//     Route::post('/auth/refresh', [AuthController::class, 'refresh']);
//     Route::get('/auth/user-profile', [AuthController::class, 'userProfile']);
//     Route::post('/auth/depense', [DepenseController::class, 'store']);
//     Route::get('/auth/depense', [DepenseController::class, 'getDepenseByUser']);
//     Route::get('/auth/depense-actuel', [DepenseController::class, 'getTotalCurrentDepense']);
//     Route::resource('/auth/revenu', RevenuController::class);
//     Route::get('/auth/currentRevenu', 'RevenuController@revenuActuel');
//     Route::get('/auth/AllRevenuByUser', 'RevenuController@AllRevenuByUser');
//     Route::get('/auth/revenuMois', 'RevenuController@revenuMois');


// });
