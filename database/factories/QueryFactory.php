<?php

namespace Database\Factories;

use App\Models\Query;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Type\Integer;

class QueryFactory extends Factory
{

    protected $model = Query::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber,
            'title' => $this->faker->sentence(12),
            'description' => $this->faker->sentence(30),
            'status' => 0,
            // 'response_text' => $this->faker->sentence(30),
        ];
    }
}