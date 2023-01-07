<?php

namespace Database\Factories;

use App\Models\DeclarationTemplateQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeclarationTemplateQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeclarationTemplateQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'declaration_template_id' => $this->faker->word,
        'type' => $this->faker->word,
        'question' => $this->faker->word,
        'code' => $this->faker->word,
        'data' => $this->faker->text,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
