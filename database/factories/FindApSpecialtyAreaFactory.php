<?php

namespace Database\Factories;

use App\Models\FindApSpecialtyArea;
use Illuminate\Database\Eloquent\Factories\Factory;

class FindApSpecialtyAreaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FindApSpecialtyArea::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'find_ap_id' => $this->faker->word,
        'specialty_area' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
