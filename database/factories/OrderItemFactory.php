<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'associate_id' => $this->faker->word,
        'declaration_id' => $this->faker->word,
        'quota_id' => $this->faker->word,
        'order_id' => $this->faker->word,
        'product_id' => $this->faker->word,
        'cookie' => $this->faker->word,
        'name' => $this->faker->word,
        'quantity' => $this->faker->randomDigitNotNull,
        'price' => $this->faker->word,
        'notes' => $this->faker->word,
        'vat' => $this->faker->word,
        'raw_data' => $this->faker->text,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
