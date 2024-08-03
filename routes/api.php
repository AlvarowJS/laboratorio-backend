<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ExamController as Exam;
use App\Http\Controllers\Api\V1\ExamtypeController as ExamType;
use App\Http\Controllers\Api\V1\LotController as Lot;
use App\Http\Controllers\Api\V1\AuthController as Auth;


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

Route::post('/login', [Auth::class, 'login']);
Route::post('/register', [Auth::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/token-auth', [Auth::class, 'authToken']);
    Route::apiResource('/v1/exam', Exam::class);
    Route::apiResource('/v1/lot', Lot::class);
    Route::apiResource('/v1/exam-type', ExamType::class);
    Route::apiResource('/v1/users', Auth::class);
});
