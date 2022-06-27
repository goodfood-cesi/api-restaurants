<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function destroy(int $restaurant_id, int $product_id): JsonResponse {
        try {
            return $this->success((Restaurant::findOrFail($restaurant_id)->products()->findOrFail($product_id))->delete(), 'Product deleted');
        } catch (Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, int $restaurant_id, int $product_id): JsonResponse {
        try {
            $product = Restaurant::findOrFail($restaurant_id)?->products()->findOrFail($product_id);

            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'image' => 'required|string',
                'amount' => 'required|between:0,99.99',
                'description' => 'required|string',
            ]);

            if($validator->fails()){
                return $this->error('Wrong informations');    
            }

            $product->name = $request->input('name');
            $product->image = $request->input('image'); 
            $product->amount = $request->input('amount'); 
            $product->description = $request->input('description');
            $product->save();

            return $this->success('Product updated');
        } catch (Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
