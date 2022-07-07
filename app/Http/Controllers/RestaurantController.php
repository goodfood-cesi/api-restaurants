<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends Controller{
    public function index(): JsonResponse {
        return $this->success(RestaurantResource::collection(Restaurant::all()), 'Restaurants loaded');
    }

    public function show(int $restaurant_id): JsonResponse {
        return $this->success(new RestaurantResource(Restaurant::findOrFail($restaurant_id)), 'Restaurant loaded');
    }

    public function store(Request $request): JsonResponse {
        $input = $this->validate($request,[
            'name' => 'required|string',
            'image' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'phone' => 'required|string',
            "days" => 'nullable|array',
            "days.monday" => 'nullable|string',
            'days.tuesday' => 'nullable|string',
            'days.wednesday' => 'nullable|string',
            'days.thursday' => 'nullable|string',
            'days.friday' => 'nullable|string',
            'days.saturday' => 'nullable|string',
            'days.sunday' => 'nullable|string',
        ]);

        if(isset($input['days'])) {
            foreach ($input['days'] as $key => $value) {
                $input[$key] = $value;
            }
            unset($input['days']);
        }


        $restaurant = Restaurant::create($input);
        return $this->ressourceCreated(new RestaurantResource($restaurant), 'Restaurant created');
    }

    public function update(Request $request, int $restaurant_id): JsonResponse {
        $restaurant = Restaurant::findOrFail($restaurant_id);
        $input = $this->validate($request,[
            'name' => 'string',
            'image' => 'string',
            'address' => 'string',
            'latitude' => 'string',
            'longitude' => 'string',
            'phone' => 'string',
            'monday' => 'nullable|string',
            'tuesday' => 'nullable|string',
            'wednesday' => 'nullable|string',
            'thursday' => 'nullable|string',
            'friday' => 'nullable|string',
            'saturday' => 'nullable|string',
            'sunday' => 'nullable|string',
        ]);

        $restaurant->update($input);
        return $this->success(new RestaurantResource($restaurant), 'Restaurant updated');
    }

    public function destroy(int $restaurant_id): JsonResponse {
        Restaurant::findOrFail($restaurant_id)?->delete();
        return $this->ressourceDeleted();
    }
}
