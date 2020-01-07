<?php

use Illuminate\Http\Request;

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

// 路由功能
Route::get('/test/route', 'RouteController@get');
Route::post('/test/route', 'RouteController@post');
Route::put('/test/route', 'RouteController@put');
Route::patch('/test/route', 'RouteController@patch');
Route::delete('/test/route', 'RouteController@delete');
Route::options('/test/route', 'RouteController@options');
Route::match(['get', 'post'], '/test/route/match', 'RouteController@match');
Route::any('/test/route/any', 'RouteController@any');
Route::get('/test/route/{id}', 'RouteController@routeWhere')->where('id', '[0-9]+')->name('route_where');


Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::get('/hello', "HelloController@hello");
Route::get('/after', "HelloController@after");
Route::get('/tick', "HelloController@tick");
Route::get('/clearTimer', "HelloController@clearTimer");
Route::get('/reload', "HelloController@reload");
Route::get('/info', "HelloController@info");
Route::get('/table', "HelloController@table");
Route::get('/task', "HelloController@task");
Route::get('/complexTask', "HelloController@complexTask");
Route::get('/request', "RequestController@info");
Route::get('/cookie/test', "CookieController@test");

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->get('users/{id}', 'App\Api\Controllers\UserController@show');
});

$api->version('v2', function ($api) {
    $api->get('users/{id}', 'App\Api\V2\Controllers\UserController@show');
});

$api->version('v1', function ($api) {
    $api->get('/task/{id}', function ($id) {
        return \App\Models\Test::findOrFail($id);
    });
});
