<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return "Quiero chamba " . $router->app->version();
});

# Descarga de archivos
$router->group(['prefix' => 'dwl'], function () use ($router) {
    $router->get('/solicitantes/{idSolicitante}', 'SolicitanteController@descarga_cv');
    $router->get('/empresas/{idEmpresa}/{archivo}', 'EmpresaController@descarga_archivo');
    $router->get('/noticias/{idNoticia}', 'NoticiasController@descarga_imagen');
});

$router->group(['prefix' => 'noticias'], function () use ($router) {
    $router->get('/listado', 'NoticiasController@listado');
    $router->get('/detalle/{id}', 'NoticiasController@searchById');
});

# Rutas para sistema admin (valida autenticacion de usuario)
$router->group(['middleware' => array('jwt.auth', 'cors')], function ($router) {

    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->get('/listado', 'VacanteController@getVacantes');
        $router->delete('/eliminar/{id}', 'VacanteController@inhabilitar');
        $router->post('/vincular', 'VacanteController@vincular');
        $router->post('/guardar', 'VacanteController@save');
    });

    $router->group(['prefix' => 'solicitantes'], function () use ($router) {
        $router->post('/guardarCv', 'SolicitanteController@guardarCv');
        $router->get('/borrarCv/{idSolicitante}', 'SolicitanteController@borrarCv');
        $router->post('/editar', 'SolicitanteController@editar');
    });

    $router->group(['prefix' => 'empresas'], function () use ($router) {
        $router->get('/listado', 'EmpresaController@listado');
        $router->post('/updateEstatusEmpresa', 'EmpresaController@updateEstatusEmpresa');
        $router->get('/getEstatusEmpresas', 'EmpresaController@getEstatusEmpresas');
        $router->get('/detalle/{idSolicitante}', 'EmpresaController@searchById');
        $router->post('/guardarDocto', 'EmpresaController@guardarDocto');
        $router->get('/borrarDocto/{idEmpresa}/{archivo}', 'EmpresaController@borrarDocto');
        $router->post('/editar', 'EmpresaController@editar');
    });

    $router->group(['prefix' => 'usuarios'], function () use ($router) {
        $router->get('/listado', 'UsuarioController@listado');
        $router->get('/detalle/{usuarioId}', 'UsuarioController@detalle');
        $router->post('/guardar', 'UsuarioController@guardar');
        $router->post('/editar', 'UsuarioController@editar');
        $router->delete('/eliminar/{id}', 'UsuarioController@inhabilitar');
    });

    #websocket
    $router->group(['prefix' => 'ws'], function () use ($router) {
        $router->post('/up', 'SocketController@saveConnection'); // Da de alta la conexion del cliente al websocket
        $router->post('/down', 'SocketController@deleteConnection'); // Da de baja la conexion del cliente al websocket
        $router->post('/set_seen', 'SocketController@setSeen'); // Cambia el campo 'vista' de una notificación
        $router->post('/set_sended', 'SocketController@setSended'); // Cambia el campo 'enviada' de una notificación
        $router->get('/getLastNotifications/{usuarioId}', 'SocketController@getLastNotifications');
        $router->get('/getAllNotifications/{usuarioId}', 'SocketController@getAllNotifications');
        $router->get('/setNotificationSeen/{notifId}', 'SocketController@setNotificationSeen');
        $router->delete('/deleteNotification/{notifId}', 'SocketController@deleteNotification');
    });

    $router->group(['prefix' => 'correo'], function () use ($router) {
        $router->post('/broadcast', 'CorreoController@broadcast');
    });

    $router->group(['prefix' => 'reportes'], function () use ($router) {
        $router->get('/generales', 'ReportesController@generales');
        $router->get('/conversion', 'ReportesController@graficaConversion');
    });

    $router->group(['prefix' => 'contacto'], function () use ($router) {
        $router->get('/listado', 'ContactoController@listado');
        $router->delete('/eliminar/{id}', 'ContactoController@eliminar');
    });

    $router->group(['prefix' => 'noticias'], function () use ($router) {

        $router->post('/guardar', 'NoticiasController@guardar');
        $router->post('/editar', 'NoticiasController@editar');
        $router->delete('/eliminar/{id}', 'NoticiasController@eliminar');
    });
}); //...rutas admin

$router->group(['middleware' => array('JwtTokenOpcionalMiddleware', 'cors')], function ($router) {
    $router->group(['prefix' => 'vacantes'], function () use ($router) {
        $router->post('/detalle', 'VacanteController@searchId');
        $router->post('/filtro', 'VacanteController@filtro');
    });
    $router->group(['prefix' => 'talentHunting'], function () use ($router) {
        $router->post('/filtro', 'EmpresaController@filtroDeBusquedaSolicitantes');
        $router->post('/vincular', 'EmpresaController@vincularPostulantes');
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
        $router->get('/nivelesEduc', 'SolicitanteController@getNivelesEducativos');
        $router->get('/detalle/{idSolicitante}', 'SolicitanteController@searchById');
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
        $router->post('/updateEstatusSolicitud', 'VacanteController@updateEstatusSolicitud');
        $router->get('/getEstatusPostulacion', 'VacanteController@getEstatusPostulacion');
        $router->post('/vacanteMasLejana', 'VacanteController@vacanteMasLejana');
        $router->get('/test', 'VacanteController@test');
    });

    #websocket
    $router->group(['prefix' => 'ws'], function () use ($router) {
        $router->post('/reset', 'SocketController@resetConnections'); // Limpia tabla de conexiones de clientes con el websocket activas
        $router->get('/list', 'SocketController@listConnections'); // Obtiene la lista de las conexiones de clientes con el websocket activas
        $router->post('/testAddToQueque', 'SocketController@testAddToQueque');
    });

    $router->group(['prefix' => 'contacto'], function () use ($router) {
        $router->post('/guardar', 'ContactoController@guardar'); // Obtiene la lista de las conexiones de clientes con el websocket activas
    });

    $router->group(['prefix' => 'noticias'], function () use ($router) {
        $router->get('/publicas', 'NoticiasController@listadoPublicas');
    });
});
