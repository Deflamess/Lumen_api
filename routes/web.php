<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/{city}', 'WeatherController@getWeather');
$router->post('/weather', 'WeatherController@saveWeather');
$router->delete('/{city}', 'WeatherController@deleteCity');

//user - rating api
$router->get('/user/{id}', 'UserController@getUser');
$router->post('/user/', 'UserController@saveUser');
$router->delete('/user/{id}', 'UserController@deleteUser');
$router->patch('/user/{id}', 'UserController@updateUser');

//film api routes
$router->get('/film/{film}', 'FilmController@search');
