<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\JsonResponse;

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
}
