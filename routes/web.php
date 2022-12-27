<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->group(['middleware' => array('cors')], function () use ($router) {

    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->get('/listado', 'VacanteController@getVacante');
        $router->get('/buscar/{name}', 'VacanteController@searchName');
        $router->get('/detalle/{id}', 'VacanteController@searchId');
        $router->get('/eliminar/{id}', 'VacanteController@inhabilitar');
        $router->get('/getTurnos', 'TurnosTitulosController@getTurnos');
        $router->get('/getTitulos', 'TurnosTitulosController@getTitulos');
        $router->get('/filtro/{id1}/{id2}', 'VacanteController@filtro');
    });
});
