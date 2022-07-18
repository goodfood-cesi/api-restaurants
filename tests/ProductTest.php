<?php

use App\Models\Menu;
use App\Models\Product;
use App\Models\Restaurant;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ProductTest extends TestCase{
    use DatabaseMigrations;

    //CRUD Products
    /**
     * @covers App\Http\Controllers\ProductController
     * @covers App\Http\Middleware\Authenticate
     * @covers App\Http\Resources\ProductResource
     * @covers App\Models\Restaurant::products
     * @covers App\Models\User
     * @covers App\Traits\ApiResponser
     * @return void
     */
    public function test_can_create_a_product_from_a_restaurant(): void {
        $restaurant = Restaurant::factory()->create();
        $product = Product::factory()->make();
        $data = [
            'name' => $product->name,
            'description' => $product->description,
            'amount' => $product->amount,
            'image' => $product->image,
        ];

        $this->post(route('restaurants.products.store', ['restaurant_id' => $restaurant->id]), $data, ['Authorization' => "Bearer ". $this->fakeLogin()]);

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
        $this->seeInDatabase('products', [
            'name' => $product->name,
            'description' => $product->description,
            'amount' => $product->amount,
            'image' => $product->image,
        ]);
    }

    /**
     * @covers App\Http\Controllers\ProductController
     * @covers App\Http\Controllers\Controller
     * @covers App\Http\Resources\ProductResource
     * @covers App\Models\Restaurant
     * @return void
     */
    public function test_can_get_all_products_from_a_restaurant(): void {
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

    /**
     * @covers App\Http\Controllers\ProductController
     * @covers App\Http\Controllers\Controller
     * @covers App\Http\Resources\ProductResource
     * @covers App\Models\Menu
     * @covers App\Models\Restaurant
     * @return void
     */
    public function test_can_get_all_products_from_a_single_menu_from_a_restaurant(): void {
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

    /**
     * @covers App\Http\Controllers\ProductController
     * @covers App\Http\Controllers\Controller
     * @covers App\Http\Middleware\Authenticate
     * @covers App\Http\Resources\ProductResource
     * @covers App\Models\Product
     * @covers App\Models\Restaurant
     * @covers App\Models\User
     * @return void
     */
    public function test_can_update_a_single_product_from_a_restaurant() {
        $restaurant = Restaurant::factory()->create();
        $product = Product::factory()->create();
        $product->restaurants()->attach($restaurant);
        $data = [
            'name' => $product->name,
            'description' => $product->description,
            'amount' => $product->amount,
            'image' => $product->image,
        ];

        $this->patch(route('restaurants.products.update', ['restaurant_id' => $restaurant->id, 'product_id' => $product->id]), $data, ['Authorization' => "Bearer ". $this->fakeLogin()]);
        $this->seeStatusCode(200);
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
        $this->seeInDatabase('products', [
            'name' => $product->name,
            'description' => $product->description,
            'amount' => $product->amount,
            'image' => $product->image,
        ]);
    }

    /**
     * @covers App\Http\Controllers\ProductController
     * @covers App\Http\Middleware\Authenticate
     * @covers App\Models\Restaurant
     * @covers App\Models\User
     * @covers App\Traits\ApiResponser
     * @return void
     */
    public function test_can_delete_a_single_product_from_a_restaurant() {
        $restaurant = Restaurant::factory()->create();
        $products = Product::factory()->create();
        $restaurant->products()->attach($products);

        $this->delete(route('restaurants.products.destroy', ['restaurant_id' => $restaurant->id, 'product_id' => $products->id]), [], ['Authorization' => "Bearer ". $this->fakeLogin()]);
        $this->seeStatusCode(204);
        $this->notSeeInDatabase('products', ['id' => $products->id, 'deleted_at' => null]);
    }
}
