<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//portofolio api
Route::get('products', [ProductController::class, 'index']); 
Route::get('products/{id}', [ProductController::class, 'show']); 
Route::post('products', [ProductController::class, 'store']); 
Route::put('productsupdate/{id}', [ProductController::class, 'update']);
Route::delete('productdelete/{id}', [ProductController::class, 'destroy']);

//skill api
Route::get('skills', [SkillController::class, 'index']); 
Route::get('skills/{id}', [SkillController::class, 'show']); 
Route::post('skills', [SkillController::class, 'store']); 
Route::put('skillsupdate/{id}', [SkillController::class, 'update']);
Route::delete('skilldelete/{id}', [SkillController::class, 'destroy']);