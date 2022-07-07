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
$router->get('/', function () use ($router) {
    $response = [
        'data' => "Good Food API - Restaurants",
        'meta' => [
            'success' => true,
            'message' => 'API',
        ],
    ];
    return response()->json($response);
});

$router->group(['prefix' => 'restaurants'], function (Router $router) {
    $router->get('/', ['as' => 'restaurants.index', 'uses' => 'RestaurantController@index']);
    $router->get('/{restaurant_id}', ['as' => 'restaurants.show', 'uses' => 'RestaurantController@show']);
    $router->group(['middleware' => 'auth'], function (Router $router) {
        $router->post('/', ['as' => 'restaurants.store', 'uses' => 'RestaurantController@store']);
        $router->patch('/{restaurant_id}', ['as' => 'restaurants.update', 'uses' => 'RestaurantController@update']);
        $router->delete('/{restaurant_id}', ['as' => 'restaurants.destroy', 'uses' => 'RestaurantController@destroy']);
    });

    $router->group(['prefix' => '{restaurant_id}/menus'], function (Router $router) {
        $router->get('/', ['as' => 'restaurants.menus.index', 'uses' => 'MenuController@index']);
        $router->get('/{menu_id}', ['as' => 'restaurants.menus.show', 'uses' => 'MenuController@show']);
        $router->get('/{menu_id}/products', ['as' => 'restaurants.menus.products.index', 'uses' => 'ProductController@index']);
        $router->group(['middleware' => 'auth'], function (Router $router) {
            $router->post('/', ['as' => 'restaurants.menus.store', 'uses' => 'MenuController@store']);
            $router->patch('/{menu_id}', ['as' => 'restaurants.menus.update', 'uses' => 'MenuController@update']);
            $router->delete('/{menu_id}', ['as' => 'restaurants.menus.destroy', 'uses' => 'MenuController@destroy']);
        });
    });

    $router->group(['prefix' => '{restaurant_id}/products'], function (Router $router) {
        $router->get('/', ['as' => 'restaurants.products.index', 'uses' =>'ProductController@index']);
        $router->get('/{product_id}', ['as' => 'restaurants.products.show', 'uses' => 'ProductController@show']);
        $router->group(['middleware' => 'auth'], function (Router $router) {
            $router->post('/', ['as' => 'restaurants.products.store', 'uses' => 'ProductController@store']);
            $router->patch('/{product_id}', ['as' => 'restaurants.products.update', 'uses' => 'ProductController@update']);
            $router->delete('/{product_id}', ['as' => 'restaurants.products.destroy', 'uses' => 'ProductController@destroy']);
        });
    });
});




