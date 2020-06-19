<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\User as UserResource;
use App\User;

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

Route::post('/user/register','API\RegistrationController@register');
Route::post('/user/login','API\RegistrationController@login');

Route::middleware('jwt.auth')->group(function (){
    Route::get('/user', function (Request $request) {
        return new UserResource(auth()->user());//->makeHidden(['created_at','updated_at']));
    });

    Route::resource('/books','API\BookController');
});

