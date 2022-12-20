<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => array('cors')], function () use ($router) {
    $router->group(['prefix' => 'auth'], function ($router) {
        $router->get('/login', 'AuthController@authenticate');
    });
});

$router->group(['middleware' => array('cors')], function () use ($router) {

    
$router->group(['prefix' => 'vacantes'], function () use ($router) {
    $router->get('/listado', 'VacanteController@getVacante');
    $router->get('/buscar/{name}', 'VacanteController@searchName');
    $router->get('/detalle/{id}', 'VacanteController@searchId');
    $router->get('/eliminar/{id}', 'VacanteController@inhabilitar');
});

});
