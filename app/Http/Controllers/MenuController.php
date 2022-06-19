<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller {
    public function index(int $restaurant_id): JsonResponse {
        try {
            return $this->success(MenuResource::collection(Restaurant::findOrFail($restaurant_id)?->menus), 'Menus loaded');
        } catch (Exception $e){
            return $this->error('Restaurant does not exist.');
        }
    }

    public function show(int $restaurant_id, int $menu_id): JsonResponse {
        try {
            return $this->success(new MenuResource(Restaurant::findOrFail($restaurant_id)?->menus()->findOrFail($menu_id)), 'Menu fetched');
        } catch (Exception $e){
            return $this->error('Resource does not exist.');
        }
    }

    public function destroy(int $restaurant_id, int $menu_id): JsonResponse {
        try {
            return $this->success((Restaurant::findOrFail($restaurant_id)?->menus()->findOrFail($menu_id))->delete(), 'Menu deleted');
        } catch (Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, int $restaurant_id, int $menu_id): JsonResponse {
        try {
            $menu = Restaurant::findOrFail($restaurant_id)?->menus()->findOrFail($menu_id);

            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'image' => 'required|string',
                'amount' => 'required|between:0,99.99',
                'description' => 'required|string',
            ]);

            if($validator->fails()){
                return $this->error('Wrong informations');    
            }

            $menu->name = $request->input('name');
            $menu->image = $request->input('image'); 
            $menu->amount = $request->input('amount'); 
            $menu->description = $request->input('description');
            $menu->save();

            return $this->success('Menu updated');
        } catch (Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
