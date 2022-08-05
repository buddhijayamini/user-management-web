<?php

use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\UserController;
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
Route::get('test',function () {
    dd("test");
});

/* Authentication */
Route::group(['middleware' => ['cors'],'prefix' => 'v1/auth'], function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [EmployeeController::class,'store'])->name('register');
});

Route::group([
    'middleware' => ['auth:api'],
    'prefix' => 'v1'
], function () {
    Route::apiResource('/company', CompanyController::class)->names('company');

    Route::apiResource('/employee', EmployeeController::class)->names('employee');

    Route::post('/logout', [UserController::class,'logOut'])->name('logout');
});

Route::fallback(function(){
    return response()->json(['message' => 'Resource not found.'], 404);
});
