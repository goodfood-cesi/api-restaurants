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
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'image' => $this->faker->imageUrl(720,240),
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude(36.1426653,59.3696544),
            'longitude' => $this->faker->longitude(-5.4716872,28.0401234),
            'phone' => $this->faker->phoneNumber
        ];
    }
}
