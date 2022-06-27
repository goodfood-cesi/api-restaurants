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

$router->get('/restaurants/{restaurant_id}/products', ['as' => 'restaurants.products.index', 'uses' => 'ProductController@index']);
$router->get('/restaurants/{restaurant_id}/menus', ['as' => 'restaurants.menus.index', 'uses' => 'MenuController@index']);
$router->get('/restaurants/{restaurant_id}/menus/{menu_id}', ['as' => 'restaurants.menus.show', 'uses' => 'MenuController@show']);
$router->post('/restaurants/{restaurant_id}/menus', ['as' => 'restaurants.menus.store', 'uses' => 'MenuController@store']);
$router->patch('/restaurants/{restaurant_id}/menus/{menu_id}', ['as' => 'restaurants.menus.update', 'uses' => 'MenuController@update']);
$router->delete('/restaurants/{restaurant_id}/menus/{menu_id}', ['as' => 'restaurants.menus.destroy', 'uses' => 'MenuController@destroy']);

$router->get('/restaurants/{restaurant_id}/menus/{menu_id}/products', ['as' => 'restaurants.menus.products.index', 'uses' => 'ProductController@index']);

$router->delete('/restaurants/{restaurant_id}', ['as' => 'restaurants.destroy', 'uses' => 'RestaurantController@destroy']);
$router->delete('/restaurants/{restaurant_id}/menus/{menu_id}', ['as' => 'restaurants.menus.destroy', 'uses' => 'MenuController@destroy']);
$router->delete('/restaurants/{restaurant_id}/products/{product_id}', ['as' => 'restaurants.products.destroy', 'uses' => 'ProductController@destroy']);

$router->put('/restaurants/{restaurant_id}', ['as' => 'restaurants.update', 'uses' => 'RestaurantController@update']);
$router->put('/restaurants/{restaurant_id}/menus/{menu_id}', ['as' => 'restaurants.menus.update', 'uses' => 'MenuController@update']);
$router->put('/restaurants/{restaurant_id}/products/{product_id}', ['as' => 'restaurants.products.update', 'uses' => 'ProductController@update']);