<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name' => $this->faker->name,
            'image' => 'https://source.unsplash.com/random/2160x720/?restaurants',
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude(36.1426653, 59.3696544),
            'longitude' => $this->faker->longitude(-5.4716872, 28.0401234),
            'phone' => $this->faker->phoneNumber,
            'monday' => '11h00 - 14h00 / 18h00 - 22h00',
            'tuesday' => '11h00 - 14h00 / 18h00 - 22h00',
            'wednesday' => '11h00 - 14h00 / 18h00 - 22h00',
            'thursday' => '11h00 - 14h00 / 18h00 - 22h00',
            'friday' => '11h00 - 14h00 / 18h00 - 22h00',
            'saturday' => '11h00 - 14h00 / 18h00 - 22h00',
            'sunday' => 'Fermé'
        ];
    }
}
