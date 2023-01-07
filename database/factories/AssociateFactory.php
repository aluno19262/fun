<?php

namespace Database\Factories;

use App\Models\Associate;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssociateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Associate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->word,
        'find_ap_id' => $this->faker->word,
        'associate_number' => $this->faker->randomDigitNotNull,
        'category' => $this->faker->word,
        'name' => $this->faker->word,
        'email' => $this->faker->word,
        'phone1' => $this->faker->word,
        'phone2' => $this->faker->word,
        'vat' => $this->faker->word,
        'gender' => $this->faker->word,
        'address' => $this->faker->word,
        'zip' => $this->faker->word,
        'location' => $this->faker->word,
        'parish' => $this->faker->word,
        'municipality' => $this->faker->word,
        'district' => $this->faker->word,
        'country' => $this->faker->word,
        'associate_delegation' => $this->faker->word,
        'birthday' => $this->faker->word,
        'transmit_date' => $this->faker->word,
        'registration_date' => $this->faker->word,
        'gdpr_compliant' => $this->faker->word,
        'training_institute' => $this->faker->word,
        'quota_valid_until' => $this->faker->word,
        'newsletter' => $this->faker->word,
        'preferential_contact' => $this->faker->word,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
