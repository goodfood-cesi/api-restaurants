<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        for ($i = 0; $i < 5; $i++) {
            $restaurant = Restaurant::factory()->create();
            $products = Product::factory(10)->create();
            foreach ($products as $product) {
                $product->restaurants()->attach($restaurant);
                $menu = Menu::factory()->create();
                $menu->restaurants()->attach($restaurant);
                $product->menus()->attach($menu);
            }

            $products = Product::factory(10)->create();
            foreach ($products as $product) {
                $product->restaurants()->attach($restaurant);
            }
        }
    }
}
