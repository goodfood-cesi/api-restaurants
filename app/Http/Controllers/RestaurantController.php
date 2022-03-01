<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\JsonResponse;

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

    public function delete(int $restaurant_id): JsonResponse {
        try {
            return $this->success(Restaurant::findOrFail($restaurant_id)=>delete()), 'Restaurant deleted');
        } catch (Exception $e){
            return $this->error('Restaurant does not exist.');
        }
    }
}
