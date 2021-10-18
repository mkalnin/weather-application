<?php

/** @var Illuminate\Routing\Router $router */

$router->group(['prefix' => 'weather'], function () use ($router) {
    $router->get('by-city-name/{name}', ['uses' => 'WeatherController@byCityName']);
    $router->get('history/{numberOfQueries}/{maxDaysAgo}', ['uses' => 'WeatherController@getHistory']);
});
