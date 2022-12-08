<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->group(['middleware' => array('cors')], function () use ($router) {

    $router->get('/', function () use ($router) {
        return $router->app->version();
    });
    
$router->group(['prefix' => 'vacantes'], function () use ($router) {
    $router->get('/listado', 'VacanteController@getVacante');
    $router->get('/eliminar/{id}', 'VacanteController@inhabilitar');
    $router->get('/{id}', 'VacanteController@searchId');
});

});
