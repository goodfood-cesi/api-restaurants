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

    public function update(Request $request, int $restaurant_id): JsonResponse {
        try {
            $restaurant = Restaurant::find($restaurant_id);

            //Règles de validation ? Jour de la semaine ?

            $name->name =  $request->get('name');
            $image->image = $request->get('image');
            $address->address = $request->get('address');
            $latitude->latitude = $request->get('latitude');
            $longitude->longitude = $request->get('longitude');
            $phone->phone = $request->get('phone');
            /*$monday->monday = $request->get('monday');
            $tuesday->tuesday = $request->get('tuesday');
            $wednesday->wednesday = $request->get('wednesday');
            $thursday->thursday = $request->get('thursday');
            $friday->friday = $request->get('friday');
            $saturday->saturday = $request->get('saturday');
            $sunday->sunday = $request->get('sunday');*/
            $restaurant->save();

            return $this->success('Restaurant updated.');
        } catch (Exception $e){
            return $this->error('New restaurant informations does not match.');
        }
    }
}
