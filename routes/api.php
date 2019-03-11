<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\UserController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\UserController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\UserController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\UserController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\UserController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\UserController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
    });

    $api->group(['prefix' => 'addIP'], function(Router $api) {
        $api->post('', 'App\\Api\\V1\\Controllers\\addIpController@addIP');


    });

    $api->group(['prefix' => 'getip'], function(Router $api) {
//        $api->get('all', 'App\\Api\\V1\\Controllers\\addIpController@getAllIp');
//        $api->get('user/{id}', 'App\\Api\\V1\\Controllers\\addIpController@getUser');
        $api->delete('delete/{id}','App\\Api\\V1\\Controllers\\addIpController@deleteIp');

    });

    $api->group(['prefix' => 'script'], function(Router $api) {
        $api->get('all', 'App\\Api\\V1\\Controllers\\ScriptController@getScrip');
        $api->post('create', 'App\\Api\\V1\\Controllers\\ScriptController@createScript');
        $api->delete('{id}', 'App\\Api\\V1\\Controllers\\ScriptController@deleteScript');
    });


    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
