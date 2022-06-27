<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

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

$router->group(['prefix' => 'restaurants'], function (Router $router) {
    $router->get('/', 'RestaurantController@index');
    $router->get('/{restaurant_id}', 'RestaurantController@show');
    $router->post('/', 'RestaurantController@store');
    $router->patch('/{restaurant_id}', 'RestaurantController@update');
    $router->put('/{restaurant_id}', 'RestaurantController@update');
    $router->delete('/{restaurant_id}', 'RestaurantController@destroy');

    $router->group(['prefix' => '{restaurant_id}/menus'], function (Router $router) {
        $router->get('/', 'MenuController@index');
        $router->get('/{menu_id}', 'MenuController@show');
        $router->post('/', 'MenuController@store');
        $router->patch('/{menu_id}', 'MenuController@update');
        $router->put('/{menu_id}', 'MenuController@update');
        $router->delete('/{menu_id}', 'MenuController@destroy');

        $router->get('/{menu_id}/products', 'ProductController@index');
    });

    $router->group(['prefix' => '{restaurant_id}/products'], function (Router $router) {
        $router->get('/', 'ProductController@index');
        $router->get('/{product_id}', 'ProductController@show');
        $router->post('/', 'ProductController@store');
        $router->patch('/{product_id}', 'ProductController@update');
        $router->put('/{product_id}', 'ProductController@update');
        $router->delete('/{product_id}', 'ProductController@destroy');
    });
});




