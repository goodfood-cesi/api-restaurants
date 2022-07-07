<?php

use App\Models\Restaurant;
use Laravel\Lumen\Testing\DatabaseMigrations;

class RestaurantTest extends TestCase {
    use DatabaseMigrations;

    //CRUD Restaurants
    public function test_can_create_a_restaurant(): void {
        $restaurant = Restaurant::factory()->make(['name' => 'New Restaurant ! :)']);
        $data = [
            'name' => $restaurant->name,
            'image' => $restaurant->image,
            'address' => $restaurant->address,
            'latitude' => $restaurant->latitude,
            'longitude' => $restaurant->longitude,
            'phone' => $restaurant->phone,
            'monday' => $restaurant->monday,
            'tuesday' => $restaurant->tuesday,
            'wednesday' => $restaurant->wednesday,
            'thursday' => $restaurant->thursday,
            'friday' => $restaurant->friday,
            'saturday' => $restaurant->saturday,
            'sunday' => $restaurant->sunday,
        ];

        $this->post(route('restaurants.store'), $data, ['Authorization' => "Bearer ". $this->fakeLogin()]);

        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'address',
                'latitude',
                'longitude',
                'phone',
                'days' => [
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                ],
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
        $this->seeInDatabase('restaurants', [
            'name' => 'New Restaurant ! :)',
            'image' => $restaurant->image,
            'address' => $restaurant->address,
            'latitude' => $restaurant->latitude,
            'longitude' => $restaurant->longitude,
            'phone' => $restaurant->phone,
        ]);
    }

    public function test_can_get_all_restaurants(): void {
        Restaurant::factory()->count(30)->create();

        $this->get(route('restaurants.index'));
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'image',
                    'address',
                    'latitude',
                    'longitude',
                    'phone',
                    'days',
                ]
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
    }

    public function test_can_get_a_single_restaurant(): void {
        $restaurant = Restaurant::factory()->create();
        $this->get(route('restaurants.show', ['restaurant_id' => $restaurant->id]));
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'address',
                'latitude',
                'longitude',
                'phone',
                'days',
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
    }

    public function test_can_update_a_single_restaurant() {
        $restaurant = Restaurant::factory()->create();
        $this->patch(route('restaurants.update', ['restaurant_id' => $restaurant->id]), ['name' => 'New name'], ['Authorization' => "Bearer ". $this->fakeLogin()]);

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'address',
                'latitude',
                'longitude',
                'phone',
                'days' => [
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                ],
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
        $this->seeInDatabase('restaurants', [
            'id' => $restaurant->id,
            'name' => 'New name',
            'image' => $restaurant->image,
            'address' => $restaurant->address,
            'latitude' => $restaurant->latitude,
            'longitude' => $restaurant->longitude,
            'phone' => $restaurant->phone,
            'monday' => '11h00 - 14h00 / 18h00 - 22h00',
            'tuesday' => '11h00 - 14h00 / 18h00 - 22h00',
            'wednesday' => '11h00 - 14h00 / 18h00 - 22h00',
            'thursday' => '11h00 - 14h00 / 18h00 - 22h00',
            'friday' => '11h00 - 14h00 / 18h00 - 22h00',
            'saturday' => '11h00 - 14h00 / 18h00 - 22h00',
            'sunday' => 'Fermé'
        ]);
    }

    public function test_can_delete_a_single_restaurant(): void {
        $restaurant = Restaurant::factory()->create();
        $this->delete(route('restaurants.destroy', ['restaurant_id' => $restaurant->id]), [], ['Authorization' => "Bearer ". $this->fakeLogin()]);
        $this->seeStatusCode(204);
        $this->notSeeInDatabase('restaurants', ['id' => $restaurant->id, 'deleted_at' => null]);
    }
}
