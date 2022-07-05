<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'image' => 'required|file|mimes:jpg,png,jpeg,gif,svg,tif,tiff,bmp,gif,xe2,webp,heic,pdf|max:5000',
            'amount' => 'required|between:0,99.99',
            'description' => 'required|string',
        ]);

        $file = $request->file('image');
        $extension = $file->extension();
        $input['image'] = $_ENV['AWS_BUCKET_URL'] . '/' . $file->storePubliclyAs('', Str::uuid() . '.' . $extension, 's3');

        $menu = Restaurant::findOrFail($restaurant_id)->menus()->create($input);
        return $this->ressourceCreated(new MenuResource($menu), 'Menu created');
    }

    public function update(Request $request, int $restaurant_id, int $menu_id): JsonResponse {
        $menu = Restaurant::findOrFail($restaurant_id)?->menus()->findOrFail($menu_id);

        $input = $this->validate($request,[
            'name' => 'string',
            'image' => 'file|mimes:jpg,png,jpeg,gif,svg,tif,tiff,bmp,gif,xe2,webp,heic,pdf|max:5000',
            'amount' => 'between:0,99.99',
            'description' => 'string',
        ]);

        $file = $request->file('image');
        $extension = $file->extension();
        $input['image'] = $_ENV['AWS_BUCKET_URL'] . '/' . $file->storePubliclyAs('', Str::uuid() . '.' . $extension, 's3');

        $menu->update($input);
        return $this->success(new MenuResource($menu),'Menu updated');
    }

    public function destroy(int $restaurant_id, int $menu_id): JsonResponse {
        Restaurant::findOrFail($restaurant_id)?->menus()->findOrFail($menu_id)?->delete();
        return $this->ressourceDeleted();
    }
}
