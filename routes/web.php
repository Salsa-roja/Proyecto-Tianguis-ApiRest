<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return "Quiero chamba " . $router->app->version();
});
# Rutas para sistema admin (valida autenticacion de uuario)
$router->group(['middleware' => array('jwt.auth', 'cors')], function ($router) {
    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->get('/listado', 'VacanteController@getVacantes');
        $router->delete('/eliminar/{id}', 'VacanteController@inhabilitar');
        $router->post('/vincular', 'VacanteController@vincular');
    });
});
$router->group(['middleware' => array('JwtTokenOpcionalMiddleware', 'cors')], function ($router) {
    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->post('/detalle', 'VacanteController@searchId');
        $router->post('/filtro', 'VacanteController@filtro');

    });
});
# Rutas para landing
$router->group(['middleware' => array('cors')], function () use ($router) {

    $router->group(['prefix' => 'auth'], function ($router) {
        $router->get('/login', 'AuthController@authenticate');
    });
    $router->get('/c_postales', 'SolicitanteController@getCPs');
    $router->get('/colonias/{cpostal}', 'SolicitanteController@getColonias');
    $router->group(['prefix' => 'registro-solicitante'], function () use ($router) {
        $router->post('/guardar', 'SolicitanteController@guardar');
    });
    $router->group(['prefix' => 'registro-empresa'], function () use ($router) {
        $router->post('/guardar', 'EmpresaController@guardar');
    });
    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->get('/listadoSolicitudes/{idVacante}', 'VacanteController@getSolicitudesVacante');
        $router->get('/buscar/{name}', 'VacanteController@searchName');
        // funcion eliminar agregada en rutas admin arriba
        // $router->post('/detalle', 'VacanteController@searchId');
        $router->get('/getTurnos', 'TurnosTitulosController@getTurnos');
        $router->get('/getTitulos', 'TurnosTitulosController@getTitulos');
        $router->post('/vacanteMasLejana', 'VacanteController@vacanteMasLejana');

    });
    $router->group(['prefix' => 'correo'], function () use ($router) {
        $router->get('/detalle/{correo_id}', 'CorreoController@correoById');
        $router->post('/enviar', 'CorreoController@enviar');
        $router->get('/gethosts', 'CorreoController@get_hosts');
    });
});
