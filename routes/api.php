<?php

use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SuperAdmin\AdminController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\User\NoteController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [ AuthController::class, 'login']);
Route::post('/register', [ AuthController::class, 'register']);

Route::prefix('super_admin')->middleware(['auth:sanctum', 'isSuperAdmin'])->group(function () {
    Route::post('add_admin', [AdminController::class, 'create']);
});

Route::prefix('admin')->middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('users', [UserController::class, 'list']);
});

Route::prefix('notes')->middleware(['auth:sanctum', 'isUser'])->group(function () {

    Route::get('list', [NoteController::class, 'index']);
    Route::post('add', [NoteController::class, 'create']);

});


Route::prefix('profile')->middleware(['auth:sanctum'])->group(function () {
    Route::get('me', [ProfileController::class, 'index']);
});
