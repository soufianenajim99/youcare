<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BenevoleController;
use App\Http\Controllers\OrganisateurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

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

Route::get('/orgas',[OrganisateurController::class,'index']);
Route::post('/orgas',[OrganisateurController::class,'store']);
Route::get('/mycond',[OrganisateurController::class,'myCond']);
Route::post('/accdem/{id}',[OrganisateurController::class,'accdem']);
Route::post('/refdem/{id}',[OrganisateurController::class,'refdem']);



Route::get('/benes',[BenevoleController::class,'index']);
Route::post('/benes',[BenevoleController::class,'store']);
Route::post('/reserve/{id}',[BenevoleController::class,'reserve']);


Route::get('/anno',[AnnonceController::class,'index']);
Route::post('/anno',[AnnonceController::class,'store']);



//Get current User Authenticated
Route::get('/user', function () {
    
    return response()->json([
        'user' => Auth::guard('api')->user(),
    ]);
});



Route::post('register',[AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::post('refresh', [AuthController::class,'refresh']);
Route::get('logout', [AuthController::class,'logout']);