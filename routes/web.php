<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group([
    'namespace' => '\App\Http\Api\V1\Controllers',
    'prefix' => 'api/v1',
], function ($router) {
    require __DIR__.'/../routes/api/api_v1.php';
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});
