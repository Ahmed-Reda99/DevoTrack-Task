<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'auth:sanctum'], function(){
    
    Route::get('/current-user', "UserAuthController@currentUser");

    Route::post('/logout', "UserAuthController@logout");

    Route::post('/refresh-token', "UserAuthController@refreshToken");
});

Route::post('/register', "UserAuthController@register");
Route::post('/login', "UserAuthController@login");