<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller {
    public function index(int $restaurant_id): JsonResponse {
        return $this->success(MenuResource::collection(Restaurant::findOrFail($restaurant_id)?->menus), 'Menus loaded');
    }

    public function show(int $restaurant_id, int $menu_id): JsonResponse {
        return $this->success(new MenuResource(Restaurant::findOrFail($restaurant_id)?->menus()->findOrFail($menu_id)), 'Menu fetched');
    }

    public function store(Request $request, int $restaurant_id): JsonResponse {
        $input = $this->validate($request,[
            'name' => 'required|string',
            'image' => 'required|string',
            'amount' => 'required|between:0,99.99',
            'description' => 'required|string',
        ]);

        $menu = Restaurant::findOrFail($restaurant_id)->menus()->create($input);
        return $this->ressourceCreated(new MenuResource($menu), 'Menu created');
    }

    public function update(Request $request, int $restaurant_id, int $menu_id): JsonResponse {
        $menu = Restaurant::findOrFail($restaurant_id)?->menus()->findOrFail($menu_id);

        $input = $this->validate($request,[
            'name' => 'string',
            'image' => 'string',
            'amount' => 'numeric|between:0,99.99',
            'description' => 'string',
        ]);

        $menu->update($input);
        return $this->success(new MenuResource($menu),'Menu updated');
    }

    public function destroy(int $restaurant_id, int $menu_id): JsonResponse {
        Restaurant::findOrFail($restaurant_id)?->menus()->findOrFail($menu_id)?->delete();
        return $this->ressourceDeleted();
    }
}
