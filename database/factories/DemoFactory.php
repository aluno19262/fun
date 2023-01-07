<?php

namespace Database\Factories;

use App\Models\Demo;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Demo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'body' => $this->faker->text,
        'optional' => $this->faker->word,
        'body_optional' => $this->faker->text,
        'value' => $this->faker->word,
        'date' => $this->faker->word,
        'datetime' => $this->faker->date('Y-m-d H:i:s'),
        'checkbox' => $this->faker->word,
        'privacy_policy' => $this->faker->word,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
