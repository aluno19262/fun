<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

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
        'name' => $this->faker->word,
        'email' => $this->faker->word,
        'address' => $this->faker->word,
        'zip' => $this->faker->word,
        'location' => $this->faker->word,
        'phone' => $this->faker->word,
        'vat' => $this->faker->word,
        'coupon' => $this->faker->word,
        'discount' => $this->faker->word,
        'subtotal' => $this->faker->word,
        'total' => $this->faker->word,
        'vat_value' => $this->faker->word,
        'delivery_date' => $this->faker->date('Y-m-d H:i:s'),
        'notes' => $this->faker->word,
        'payment_method' => $this->faker->word,
        'mb_ent' => $this->faker->word,
        'mb_ref' => $this->faker->word,
        'mb_limit_date' => $this->faker->word,
        'mbway_ref' => $this->faker->word,
        'mbway_alias' => $this->faker->word,
        'payment_ref' => $this->faker->word,
        'invoice_id' => $this->faker->word,
        'invoice_link' => $this->faker->word,
        'payment_limit_date' => $this->faker->word,
        'invoice_status' => $this->faker->word,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
