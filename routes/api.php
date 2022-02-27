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

$router->get('/restaurants', ['as' => 'restaurants.index', 'uses' => 'RestaurantController@index']);
$router->get('/restaurants/{restaurant_id}', ['as' => 'restaurants.show', 'uses' => 'RestaurantController@show']);
$router->get('/restaurants/{restaurant_id}/products', ['as' => 'restaurants.products.index', 'uses' => 'ProductController@index']);
$router->get('/restaurants/{restaurant_id}/products/{product_id}', ['as' => 'restaurants.products.show', 'uses' => 'ProductController@show']);
$router->get('/restaurants/{restaurant_id}/menus', ['as' => 'restaurants.menus.index', 'uses' => 'MenuController@index']);
$router->get('/restaurants/{restaurant_id}/menus/{menu_id}', ['as' => 'restaurants.menus.show', 'uses' => 'MenuController@show']);
$router->get('/restaurants/{restaurant_id}/menus/{menu_id}/products', ['as' => 'restaurants.menus.products.index', 'uses' => 'ProductController@index']);
