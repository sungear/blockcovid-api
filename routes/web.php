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

    $router->group(['prefix' => 'citoyens'], function () use ($router) {    
        $router->get('enregistrement', 'CitoyenController@store'); 
        $router->get('all', 'CitoyenController@showAll');
        //Il faut créer un Service Provider pour gérer les différents types de QR codes
        //avant d'ajouter dans frequentations si besoin et faire appel à ce Service ici.
    });

    $router->group(['prefix' => 'medecins'], function () use ($router) {  
        $router->post('{id}/qr_code', 'QrMedecinController@store');      
        $router->get('{id}', 'MedecinController@show');            
        //Pour les inscriptions, il faut créer un Service Provider pour 
        //ajouter dans createurs_de_qr (à partir du CreateurDeQrController)
        //et dans medecins (à partir du MedecinsController) et faire appel à ce Service ici.   
    });

    $router->group(['prefix' => 'etablissements'], function () use ($router) {    
        $router->post('{id}/qr_code', 'QrEtablissementController@store'); 
        //Pour les inscriptions, il faut créer un Service Provider pour 
        //ajouter dans createurs_de_qr (à partir du CreateurDeQrController)
        //et dans etablissemens (à partir du EtablissementController) et faire appel à ce Service ici.   
    });

    //A faire avec Authenticate ?
    $router->post('connexion', 'CreateurDeQrController@login');  
    
    $router->get('/', function () use ($router) {
        return 'api de blockcovid';
    });    
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});
