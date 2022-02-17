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
        for ($i = 0; $i < 1; $i++) {
            $restaurant = Restaurant::factory()->create();
            $products = Product::factory(15)->create();
            for($j = 0; $j < 5; $j++){
                $menu = Menu::factory()->create();
                $menu->restaurants()->attach($restaurant);
                foreach ($products->random(random_int(1,4)) as $product){
                    $product->restaurants()->attach($restaurant);
                    $product->menus()->attach($menu, ['quantity' => random_int(1,3)]);
                }
            }

            $products = Product::factory(10)->create();
            foreach ($products as $product) {
                $product->restaurants()->attach($restaurant);
            }
        }
    }
}
