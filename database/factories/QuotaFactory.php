<?php

namespace Database\Factories;

use App\Models\Quota;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quota::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => $this->faker->word,
        'semester' => $this->faker->word,
        'payment_limit_date' => $this->faker->word,
        'price' => $this->faker->word,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
