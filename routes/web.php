<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => array('cors')], function () use ($router) {
$router->get('/', function () use ($router) {
    return $router->app->version();
});
});