<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserCity;
use App\Models\User;
use App\Models\City;

class UserCityFactory extends Factory
{
    protected $model = UserCity::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  // Create a user if none exists
            'city_id' => City::factory(),  // Create a city if none exists
        ];
    }
}
