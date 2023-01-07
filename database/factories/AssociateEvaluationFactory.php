<?php

namespace Database\Factories;

use App\Models\AssociateEvaluation;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssociateEvaluationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AssociateEvaluation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'associate_id' => $this->faker->word,
        'user_id' => $this->faker->word,
        'phase' => $this->faker->word,
        'note' => $this->faker->text,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
