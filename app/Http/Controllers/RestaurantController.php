<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller{
    public function index(): JsonResponse {
        return $this->success(RestaurantResource::collection(Restaurant::all()), 'Restaurants loaded');
    }

    public function show(int $restaurant_id): JsonResponse {
        try {
            return $this->success(new RestaurantResource(Restaurant::findOrFail($restaurant_id)), 'Restaurant loaded');
        } catch (Exception $e){
            return $this->error('Restaurant does not exist.');
        }
    }

    public function destroy(int $restaurant_id): JsonResponse {
        try {
            return $this->success((Restaurant::findOrFail($restaurant_id))->delete(), 'Restaurant deleted');
        } catch (Exception $e){
            return $this->error('An error occured');
        }
    }

    public function update(Request $request, int $restaurant_id): JsonResponse {
        $restaurant = Restaurant::findOrFail($restaurant_id);
        $input = $this->validate($request,[
            'name' => 'string',
            'image' => 'string',
            'adress' => 'string',
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
       $this->resourceUpdated(new RestaurantResource($restaurant), 'Restaurant Updated');
    }
}
