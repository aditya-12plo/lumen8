<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
$router->get('/',['as' => 'index','uses' => 'IndexController@index']);
$router->get('/coba',['as' => 'index','uses' => 'ExampleController@index']);
$router->get('/version', function () use ($router) {
    return $router->app->version();
});


Route::group([
    'prefix' => 'api'

], function ($router) {
 
    $router->post('oauth/login',['as' => 'userLogin','uses' => 'Auth\LoginController@authenticate']);
    
    $router->group(
        ['middleware' => 'jwt.auth'], 
        function() use ($router) {

            $router->get('profile',['as' => 'userProfile','uses' => 'UserController@profile']);
        }
    );
});


