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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


//$router->group(['prefix' => 'api'], function () use($router) {
//User routes
$router->group(['prefix' => 'user'], function () use($router) {
    $router->get('/', 'UsersController@index');
    $router->get('/{id}', 'UsersController@show');
});
//Roles routes
$router->group(['prefix' => 'roles'], function () use($router) {
    $router->get('/', 'RolesController@index');
    $router->put('/{id}', 'RolesController@update');
});
//Permission routes
$router->get('/checkpermission/{userid}/{permission_id}', 'PermissionsController@checkpermission');
$router->group(['prefix' => 'permissions'], function () use($router) {
    $router->get('/', 'PermissionsController@index');
    $router->delete('/{id}', 'PermissionsController@destroy');
});
//});
