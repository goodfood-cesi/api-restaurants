<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller{
    public function index(int $restaurant_id, int $menu_id = null): JsonResponse {
        $restaurant = Restaurant::findOrFail($restaurant_id);
        if(isset($menu_id)){
            $products = $restaurant->menus()->findOrFail($menu_id)?->products;
        } else {
            $products = $restaurant->products;
        }
        return $this->success(ProductResource::collection($products), 'Products loaded');
    }

    public function show(int $restaurant_id, int $product_id): JsonResponse {
        return $this->success(new ProductResource(
            Restaurant::findOrFail($restaurant_id)->products()->findOrFail($product_id)
        ), 'Products loaded');
    }

    public function store(Request $request, int $restaurant_id): JsonResponse {
        $input = $this->validate($request,[
            'name' => 'required|string',
            'image' => 'required|string',
            'amount' => 'required|between:0,99.99',
            'description' => 'required|string',
        ]);

        $product = Restaurant::findOrFail($restaurant_id)->products()->create($input);
        return $this->ressourceCreated(new ProductResource($product), 'Product created');
    }

    public function update(Request $request, int $restaurant_id, int $product_id): JsonResponse {
        $product = Restaurant::findOrFail($restaurant_id)?->products()->findOrFail($product_id);

        $input = $this->validate($request,[
            'name' => 'string',
            'image' => 'string',
            'amount' => 'between:0,99.99',
            'description' => 'string',
        ]);

        $product->update($input);
        return $this->success(new ProductResource($product), 'Product updated');
    }

    public function destroy(int $restaurant_id, int $product_id): JsonResponse {
        Restaurant::findOrFail($restaurant_id)?->products()->findOrFail($product_id)?->delete();
        return $this->ressourceDeleted();
    }
}
