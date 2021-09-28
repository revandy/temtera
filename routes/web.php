<?php
use \Illuminate\Http\Request;
use App\Models\User;
/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// $router->get('/login', function (Request $request) {
//     $token = app('auth')->attempt($request->only('email', 'password'));
//     return response()->json(compact('token'));
// });
Route::group([

    'namespace' => '\App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    // GET MEMBER
    Route::get('member', 'MemberController@getMember');
    
});


$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->group(['prefix' => 'member'], function () use ($router) {

        Route::get('/', 'MemberController@getMember');
        
    });

});

// STORE DATA MEMBER
Route::get('member/store', 'MemberController@storeMember');