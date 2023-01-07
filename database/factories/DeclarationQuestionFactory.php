<?php

namespace Database\Factories;

use App\Models\DeclarationQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeclarationQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeclarationQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'associate_id' => $this->faker->word,
        'declaration_template_id' => $this->faker->word,
        'declaration_number' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->word,
        'emited_at' => $this->faker->date('Y-m-d H:i:s'),
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
