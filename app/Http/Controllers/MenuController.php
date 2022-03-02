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

    public function store(Request $request, int $restaurant_id): JsonResponse {
        $input = $request->only(
            'name',
            'image',
            'amount',
            'description'
        );
        $validator = Validator::make($input,[
            'name' => 'required|string',
            'image' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'required|string'
        ]);

        if($validator->fails()){
            return $this->error('Wrongs inputs', $validator->errors()->toArray(), 422);
        }
        $menu = Restaurant::findOrFail($restaurant_id)?->menus()->create($input);
        return $this->ressourceCreated(new MenuResource($menu), "Menu created");
    }

    public function update(Request $request, int $restaurant_id, int $menu_id){
        $input = $request->only([
            'name',
            'image',
            'amount',
            'description'
        ]);

        $validator = Validator::make($input,[
            'name' => 'string',
            'image' => 'string',
            'amount' => 'numeric',
            'description' => 'string'
        ]);

        if($validator->fails()){
            return $this->error('Wrongs inputs', $validator->errors()->toArray(), 422);
        }

        $menu = Restaurant::findOrFail($restaurant_id)->menus()->findOrFail($menu_id);
        $menu->update($input);
        return $this->success(new MenuResource($menu), "Menu updated");
    }

    public function destroy(int $restaurant_id, int $menu_id): JsonResponse {
        Restaurant::findOrFail($restaurant_id)?->menus()->findOrFail($menu_id)?->delete();
        return $this->ressourceDeleted();
    }
}
