<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CORSMiddleware;

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


/*
|--------------------------------------------------------------------------
| login routes
|--------------------------------------------------------------------------
*/
Route::post('/login', 'Auth\ApiAuthController@login');




/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::post('/registerCustomer', 'Auth\ApiAuthController@registerCustomer');


Route::middleware(['auth:api',CORSMiddleware::class])->group(function () {

    Route::resource('/authorsPreferences', 'AuthorPreferencesController');
    Route::resource('/catagoryPreferences', 'CatagoryPreferencesController');
    Route::resource('/sourcePreferences', 'SourcePreferencesController');

    /*
|--------------------------------------------------------------------------
| application data at first load
|--------------------------------------------------------------------------
*/
    Route::get('/preDataLoad', 'Auth\ApiAuthController@preData');

/*
|--------------------------------------------------------------------------
| login controller routes for user data handling appAuth
|--------------------------------------------------------------------------
*/

    Route::post('/registerUser', 'Auth\ApiAuthController@registerUser');

    Route::get('/logout', 'Auth\ApiAuthController@logout');

    Route::get('/loginCheck', 'Auth\ApiAuthController@LoginCheck');




});



