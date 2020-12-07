<?php

use Illuminate\Http\Request;
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

    $router->group(['prefix' => 'citoyens'], function () use ($router) { 
        $router->post('enregistrement', ['middleware' => 'uuid', 'uses' => 'CitoyenController@store']);
        $router->post('qr-code', 'CitoyenController@storeQrCode');
        $router->put('mise-a-jour', 'CitoyenController@edit');
    });

    $router->group(['prefix' => 'medecins'], function () use ($router) {  
        $router->get('qr-code', ['middleware' => ['auth', 'uuid'], 'uses' => 'QrMedecinController@store']);     
        $router->post('inscription', ['middleware' => ['uuid', 'validator'], 'uses' => 'MedecinController@store']);  
    });

    $router->group(['prefix' => 'etablissements'], function () use ($router) {    
        $router->post('qr-code', ['middleware' => ['auth', 'uuid'], 'uses' => 'QrEtablissementController@store']); 
        $router->post('inscription', ['middleware' => ['uuid', 'validator'], 'uses' => 'EtablissementController@store']); 
    });

    $router->group(['prefix' => 'tests'], function () use ($router) {     
        $router->get('medecin/{id}', 'MedecinController@show'); 
        $router->get('citoyens/all', 'CitoyenController@showAll');  
        $router->get('medecins/all', 'MedecinController@showAll');
        $router->get('etablissement/{id}', 'EtablissementController@show');
        $router->get('etablissements/all', 'EtablissementController@showAll');
        $router->get('createurs-de-qr/me', ['middleware' => 'auth', 'uses' => 'CreateurDeQrController@show']);
<<<<<<< HEAD
        $router->get('qr_medecin/{id}', 'QrMedecinController@show');
        $router->get('qr_medecins/all', 'QrMedecinController@showAll');
        $router->get('qr_etablissement/{id}', 'QrEtablissementController@show');
        $router->get('qr_etablissements/all', 'QrEtablissementController@showAll');
=======
        $router->get('citoyens/notify', 'CitoyenController@notify');
>>>>>>> d642df955193ac2e2308a9d6bc933bee15503936
    });

    $router->post('connexion', ['middleware' => 'validator', 'uses' => 'CreateurDeQrController@login']);  
    
    $router->get('/', function () use ($router) {
        return 'api de BlockCovid groupe 10';
    });    
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});
