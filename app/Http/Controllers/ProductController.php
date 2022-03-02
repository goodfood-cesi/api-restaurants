<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller{
    public function index(int $restaurant_id, int $menu_id = null): JsonResponse {
        try {
            $restaurant = Restaurant::findOrFail($restaurant_id);
            if(isset($menu_id)){
                $products = $restaurant->menus()->findOrFail($menu_id)?->products;
            } else {
                $products = $restaurant->products;
            }
            return $this->success(ProductResource::collection($products), 'Products loaded');
        } catch (Exception $e){
            return $this->error('Resource does not exist.');
        }
    }

    public function show(int $restaurant_id, int $product_id): JsonResponse {
        return $this->success(new ProductResource(
            Restaurant::findOrFail($restaurant_id)->products()->findOrFail($product_id)
        ), 'Products loaded');
    }
}
