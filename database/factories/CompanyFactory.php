<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'email' => $this->faker->word,
        'address' => $this->faker->word,
        'phone' => $this->faker->word,
        'zip' => $this->faker->word,
        'location' => $this->faker->word,
        'parish' => $this->faker->word,
        'municipality' => $this->faker->word,
        'district' => $this->faker->word,
        'country' => $this->faker->word,
        'vat' => $this->faker->word,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
