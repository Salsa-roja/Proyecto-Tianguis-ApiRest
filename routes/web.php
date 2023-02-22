<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return "Quiero chamba " . $router->app->version();
});

# Descarga de archivos
$router->group(['prefix' => 'dwl'], function () use ($router) {
    $router->get('/solicitantes/{idSolicitante}', 'SolicitanteController@descarga_cv');
    $router->get('/empresas/{idEmpresa}/{archivo}', 'EmpresaController@descarga_archivo');
});

# Rutas para sistema admin (valida autenticacion de usuario)
$router->group(['middleware' => array('jwt.auth', 'cors')], function ($router) {

    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->get('/listado', 'VacanteController@getVacantes');
        $router->delete('/eliminar/{id}', 'VacanteController@inhabilitar');
        $router->post('/vincular', 'VacanteController@vincular');
        $router->post('/guarda', 'VacanteController@save');

    });

    $router->group(['prefix' => 'solicitantes'], function () use ($router) {
        $router->post('/guardarCv', 'SolicitanteController@guardarCv');
        $router->get('/borrarCv/{idSolicitante}', 'SolicitanteController@borrarCv');
    });

    $router->group(['prefix' => 'empresas'], function () use ($router) {
        $router->get('/listado', 'EmpresaController@listado');
        $router->get('/detalle/{idSolicitante}', 'EmpresaController@searchById');
        $router->post('/guardarDocto', 'EmpresaController@guardarDocto');
        $router->get('/borrarDocto/{idEmpresa}/{archivo}', 'EmpresaController@borrarDocto');

    });

    $router->group(['prefix' => 'usuarios'], function () use ($router) {
        $router->get('/listado', 'UsuarioController@listado');
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

    #Solicitantes
    $router->group(['prefix' => 'solicitantes'], function () use ($router) {
        $router->get('/c_postales', 'SolicitanteController@getCPs');
        $router->get('/colonias/{cpostal}', 'SolicitanteController@getColonias');
        $router->get('/detalle/{idSolicitante}', 'SolicitanteController@searchById');
        $router->post('/editar', 'SolicitanteController@editar');
    });
    $router->group(['prefix' => 'registro-solicitante'], function () use ($router) {
        $router->post('/guardar', 'SolicitanteController@guardar');
    });

    #empresas
    $router->group(['prefix' => 'registro-empresa'], function () use ($router) {
        $router->post('/guardar', 'EmpresaController@guardar');
    });

    #vacantes
    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->get('/listadoSolicitudes/{idVacante}', 'VacanteController@getSolicitudesVacante');
        $router->get('/buscar/{name}', 'VacanteController@searchName');
        $router->get('/getTurnos', 'TurnosTitulosController@getTurnos');
        $router->get('/getTitulos', 'TurnosTitulosController@getTitulos');      
        $router->post('/updateEstatusSolisitud', 'VacanteController@updateEstatusSolisitud');              
        $router->get('/getEstatusPostulacion', 'VacanteController@getEstatusPostulacion');          
        $router->post('/vacanteMasLejana', 'VacanteController@vacanteMasLejana');
    });

    #correo
    $router->group(['prefix' => 'correo'], function () use ($router) {
        $router->get('/detalle/{correo_id}', 'CorreoController@correoById');
        $router->post('/enviar', 'CorreoController@enviar');
        $router->get('/gethosts', 'CorreoController@get_hosts');
        $router->post('/broadcast', 'CorreoController@broadcast');
    });
});
