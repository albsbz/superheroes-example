<?php

namespace Database\Factories;

use App\Models\Superhero;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuperheroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Superhero::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nickname' => $this->faker->name,
            'real_name' => "{$this->faker->firstName} {$this->faker->lastName}",
            'catch_phrase' => $this->faker->realText(30),
            'origin_description' => $this->faker->realText(150),
            // 'favorites' => rand(0, 1)
        ];
    }
}
