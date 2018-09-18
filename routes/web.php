<?php

$router->get('/', 'TestController');
$router->post('/', 'TestController');

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->get('get_token', function () use ($router) {
            return response()->make(include 'get_token.html', 200);
        });
        $router->get('classting', 'OAuthController@classting');
        $router->get('classting_handle', 'OAuthController@classtingHandle');
    });
});