<?php

use App\Models\Menu;
use App\Models\Product;
use App\Models\Restaurant;
use Laravel\Lumen\Testing\DatabaseMigrations;

class RestaurantTest extends TestCase {
    use DatabaseMigrations;

    public function test_can_get_all_restaurants() {
        Restaurant::factory()->count(30)->create();

        $this->get(route('restaurants.index'));
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'image',
                    'address',
                    'latitude',
                    'longitude',
                    'phone',
                    "days",
                ]
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
    }

    public function test_can_get_a_single_restaurant() {
        $restaurant = Restaurant::factory()->create();
        $this->get(route('restaurants.show', ['restaurant_id' => $restaurant->id]));
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'address',
                'latitude',
                'longitude',
                'phone',
                "days",
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
    }

    public function test_can_get_all_menus_from_a_restaurant() {
        $restaurant = Restaurant::factory()->create();
        $menus = Menu::factory()->count(10)->create();

        foreach ($menus as $menu) {
            $products = Product::factory()->count(10)->create();
            $menu->products()->attach($products);
            $menu->restaurants()->attach($restaurant);
        }

        $this->get(route('restaurants.menus.index', ['restaurant_id' => $restaurant->id]));
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'image',
                    'amount',
                    'description',
                    'products'
                ]
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
    }

    public function test_can_get_a_single_menu_from_a_restaurant() {
        $restaurant = Restaurant::factory()->create();
        $menu = Menu::factory()->create();
        $products = Product::factory()->count(10)->create();
        $menu->products()->attach($products);
        $menu->restaurants()->attach($restaurant);

        $this->get(route('restaurants.menus.show', ['restaurant_id' => $restaurant->id, 'menu_id' => $menu->id]));
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'amount',
                'description',
                'products',
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
    }

    public function test_can_get_all_products_from_a_restaurant() {
        $restaurant = Restaurant::factory()->create();
        $products = Product::factory()->count(10)->create();
        $restaurant->products()->attach($products);


        $this->get(route('restaurants.products.index', ['restaurant_id' => $restaurant->id]));
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'image',
                    'amount',
                ]
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
    }

    public function test_can_get_all_products_from_a_single_menu_from_a_restaurant() {
        $restaurant = Restaurant::factory()->create();
        $menu = Menu::factory()->create();
        $products = Product::factory()->count(10)->create();
        $menu->products()->attach($products);
        $menu->restaurants()->attach($restaurant);

        $this->get(route('restaurants.menus.products.index', ['restaurant_id' => $restaurant->id, 'menu_id' => $menu->id]));
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'image',
                    'amount',
                ]
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
    }
}
