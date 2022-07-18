<?php

use App\Models\Menu;
use App\Models\Product;
use App\Models\Restaurant;
use Laravel\Lumen\Testing\DatabaseMigrations;

class MenuTest extends TestCase {
    use DatabaseMigrations;

    //CRUD Menus
    /**
     * @covers App\Http\Controllers\MenuController
     * @covers App\Http\Middleware\Authenticate
     * @covers App\Http\Resources\MenuResource
     * @covers App\Models\Menu
     * @covers App\Models\Restaurant
     * @covers App\Models\User
     * @covers App\Traits\ApiResponser
     * @return void
     */
    public function test_can_create_a_menu_from_a_restaurant(): void {
        $restaurant = Restaurant::factory()->create();
        $menu = Menu::factory()->make();
        $data = [
            'name' => $menu->name,
            'description' => $menu->description,
            'amount' => $menu->amount,
            'image' => $menu->image,
        ];

        $this->post(route('restaurants.menus.store', ['restaurant_id' => $restaurant->id]), $data, ['Authorization' => "Bearer ". $this->fakeLogin()]);

        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'amount',
                'image',
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
        $this->seeInDatabase('menus', [
            'name' => $menu->name,
            'description' => $menu->description,
            'amount' => $menu->amount,
            'image' => $menu->image,
        ]);
    }

    /**
     * @covers App\Http\Controllers\MenuController
     * @covers App\Http\Resources\MenuResource
     * @covers App\Models\Menu
     * @covers App\Models\Restaurant
     * @covers App\Traits\ApiResponser
     * @return void
     */
    public function test_can_get_all_menus_from_a_restaurant(): void {
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

    /**
     * @covers App\Http\Controllers\MenuController
     * @covers App\Http\Controllers\MenuController
     * @covers App\Http\Resources\MenuResource
     * @covers App\Models\Menu
     * @covers App\Models\Restaurant
     * @covers App\Traits\ApiResponser
     * @return void
     */
    public function test_can_get_a_single_menu_from_a_restaurant(): void {
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

    /**
     * @covers App\Http\Controllers\MenuController
     * @covers App\Http\Middleware\Authenticate
     * @covers App\Http\Resources\MenuResource
     * @covers App\Models\Menu
     * @covers App\Models\Restaurant
     * @covers App\Models\User
     * @covers App\Traits\ApiResponser
     * @return void
     */
    public function test_can_update_a_single_menu_from_a_restaurant(): void {
        $restaurant = Restaurant::factory()->create();
        $menu = Menu::factory()->create();
        $menu->restaurants()->attach($restaurant);

        $data = [
            'name' => 'New name',
        ];

        $this->patch(route('restaurants.menus.update', ['restaurant_id' => $restaurant->id, 'menu_id' => $menu->id]), $data, ['Authorization' => "Bearer ". $this->fakeLogin()]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'amount',
                'description',
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
        $this->seeInDatabase('menus', [
            'id' => $menu->id,
            'name' => $data['name'],
            'description' => $menu->description,
            'amount' => $menu->amount,
            'image' => $menu->image,
        ]);
    }

    /**
     * @covers App\Http\Controllers\MenuController
     * @covers App\Http\Middleware\Authenticate
     * @covers App\Models\Menu
     * @covers App\Models\Restaurant
     * @covers App\Models\User
     * @covers App\Traits\ApiResponser
     * @return void
     */
    public function test_can_delete_a_single_menu_from_a_restaurant(): void {
        $restaurant = Restaurant::factory()->create();
        $menu = Menu::factory()->create();
        $menu->restaurants()->attach($restaurant);

        $this->delete(route('restaurants.menus.destroy', ['restaurant_id' => $restaurant->id, 'menu_id' => $menu->id]), [], ['Authorization' => "Bearer ". $this->fakeLogin()]);
        $this->seeStatusCode(204);
        $this->notSeeInDatabase('menus', ['id' => $menu->id, 'deleted_at' => null]);
    }
}
