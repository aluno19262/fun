<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_id' => $this->faker->word,
        'associate_id' => $this->faker->word,
        'user_id' => $this->faker->word,
        'name' => $this->faker->word,
        'email' => $this->faker->word,
        'phone' => $this->faker->word,
        'subject' => $this->faker->word,
        'type' => $this->faker->word,
        'message' => $this->faker->text,
        'read_at' => $this->faker->date('Y-m-d H:i:s'),
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
