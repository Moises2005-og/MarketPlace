<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 20, 500);

        return [
            'user_id' => User::factory()->customer(),
            'order_number' => 'ORD-'.strtoupper(Str::random(10)),
            'status' => fake()->randomElement(OrderStatus::cases()),
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'shipping_address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
