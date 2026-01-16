<?php

namespace Database\Factories;

use App\Models\CampingSite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampingSite>
 */
class CampingSiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CampingSite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'location' => $this->faker->address(),
            'capacity' => $this->faker->numberBetween(10, 100),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'is_prime_location' => $this->faker->boolean(),
        ];
    }
}