<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->get('/', function () use ($router) {
    return "Quiero chamba ".$router->app->version();
});



# Rutas para sistema admin
$router->group(['middleware' => array('jwt.auth', 'cors')], function ($router) {

    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->delete('/eliminar/{id}', 'VacanteController@inhabilitar');
    });

}); 

# Rutas para landing
$router->group(['middleware' => array('cors')], function () use ($router) {

    $router->group(['prefix' => 'auth'], function ($router) {
        $router->get('/login', 'AuthController@authenticate');
    });

    $router->get('/c_postales', 'SolicitanteController@getCPs');
    $router->get('/colonias/{cpostal}', 'SolicitanteController@getColonias');

    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->get('/listado', 'VacanteController@getVacante');
        $router->get('/buscar/{name}', 'VacanteController@searchName');
        $router->get('/detalle/{id}', 'VacanteController@searchId');
    });

    $router->group(['prefix' => 'registro-solicitante'], function () use ($router) {
        $router->post('/guardar','SolicitanteController@guardar');
    });


});


