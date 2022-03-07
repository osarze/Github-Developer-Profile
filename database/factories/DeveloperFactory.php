<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->userName,
            'name' => $this->faker->name,
            'company' => $this->faker->company,
            'url' => $this->faker->url,
        ];
    }
}
