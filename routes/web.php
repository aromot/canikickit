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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->get('/', ['as' => 'homepage', 'uses' => 'PageController@homepage']);

$router->get('/main_app/init', ['as' => 'main_app.init', 'uses' => 'MainAppController@init']);

$router->group(['prefix' => 'users'], function() use ($router) {
  $router->post('register', ['as' => 'users.register', 'uses' => 'UserController@register']);
  $router->post('edit', ['middleware' => 'auth', 'as' => 'users.edit', 'uses' => 'UserController@edit']);
  $router->get('confirm/{activation_key}', ['as' => 'users.confirm', 'uses' => 'UserController@confirm']);
  $router->post('login', ['as' => 'users.login', 'uses' => 'UserController@login']);
  $router->post('sendPasswordReset', ['as' => 'users.sendPasswordReset', 'uses' => 'UserController@sendPasswordReset']);
  $router->get('resetPassword/{pass_reset_key}', ['as' => 'users.formResetPassword', 'uses' => 'UserController@formResetPassword']);
  $router->post('resetPassword', ['as' => 'users.resetPassword', 'uses' => 'UserController@resetPassword']);
  $router->get('logout', ['middleware' => 'auth', 'as' => 'users.logout', 'uses' => 'UserController@logout']);
  $router->get('{path:edit}', ['uses' => 'PageController@homepage']);
});

$router->get('/{path:register|login|forgot-password}', ['uses' => 'PageController@homepage']);
