<?php

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

$router->get('/', function(){
    return response()->json([
        'Its Work!'
    ]);
});
$router->get('/generate',function(){
    return \Illuminate\Support\Str::random(32);
});

// public route
$router->post('/register','AuthController@register');
$router->post('/login','AuthController@login');

// grouping route with midlleware auth
$router->group(['prefix' => 'api/v1','middleware' => 'auth'], function () use ($router) {
    // detail users
    $router->get('user/{id}','UserController@show');
    //berita internal
    $router->post('/create/berita','BeritaController@store');
    $router->get('/berita','BeritaController@show');
    $router->get('/berita/detail/{id}','BeritaController@detail');
    $router->delete('/berita/delete/{id}','BeritaController@destroyed');
    $router->post('/berita/update','BeritaController@updated');

    // category
    $router->post('/create/category','CategoryController@store');
    $router->delete('/category/delete/{id}','CategoryController@destroy');

    //Resep
    $router->post('/create/resep','ResepController@save');
    $router->get('/resep','ResepController@show');
});
