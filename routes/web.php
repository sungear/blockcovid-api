<?php

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

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'medecins'], function () use ($router) {    
        $router->get('{id}', 'MedecinController@show');        
    });

    $router->get('inscription', function () use ($router) {
        return 'inscription';
    });
    $router->get('/', function () use ($router) {
        return 'api de blockcovid';
    });
    
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});
