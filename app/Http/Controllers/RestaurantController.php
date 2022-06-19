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

<<<<<<< Updated upstream
    public function delete(int $restaurant_id): JsonResponse {
        try {
            return $this->success(Restaurant::findOrFail($restaurant_id)->delete(), 'Restaurant deleted');
        } catch (Exception $e){
            return $this->error('Restaurant does not exist.');
=======
    public function destroy(int $restaurant_id): JsonResponse {
        try {
            return $this->success((Restaurant::findOrFail($restaurant_id))->delete(), 'Restaurant deleted');
        } catch (Exception $e){
            return $this->error('An error occured');
>>>>>>> Stashed changes
        }
    }

    public function update(Request $request, int $restaurant_id): JsonResponse {
        try {
            $restaurant = Restaurant::findOrFail($restaurant_id);

<<<<<<< Updated upstream
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'required|mimes:jpeg,bmp,png,jpg',
                'address' => 'required',
                'latitude' => 'required|integer',
                'longitude' => 'required|integer',
                'phone' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->error('New restaurant informations does not match.');
            }

            $name->name = $request->get('name');
            $image->image = $request->get('image');
            $address->address = $request->get('address');
            $latitude->latitude = $request->get('latitude');
            $longitude->longitude = $request->get('longitude');
            $phone->phone = $request->get('phone');

            $restaurant->save();

            return $this->success('Restaurant updated.');
        } catch (Exception $e){
            return $this->error('New restaurant informations does not match.');
=======
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'image' => 'required|string',
                'address' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
                'phone' => 'required|string',
                'monday' => 'nullable|string',
                'tuesday' => 'nullable|string',
                'wednesday' => 'nullable|string',
                'thursday' => 'nullable|string',
                'friday' => 'nullable|string',
                'saturday' => 'nullable|string',
                'sunday' => 'nullable|string',
            ]);

            if($validator->fails()){
                return $this->error('Wrong informations');    
            }

            $restaurant->name = $request->input('name');
            $restaurant->image = $request->input('image'); 
            $restaurant->address = $request->input('address'); 
            $restaurant->latitude = $request->input('latitude');
            $restaurant->longitude = $request->input('longitude');
            $restaurant->phone = $request->input('phone'); 
            $restaurant->save();

            return $this->success('Restaurant updated');
        } catch (Exception $e){
            return $this->error($e->getMessage());
>>>>>>> Stashed changes
        }
    }
}
