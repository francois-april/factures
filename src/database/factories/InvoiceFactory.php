<?php

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => fake()->name(),
            'currency' => fake()->word(),
            'discount_rate' => rand(0, 100),
            'status' => InvoiceStatus::DRAFT,
            'issued_at' => fake()->date(),
            'due_at' => fake()->date(),
        ];
    }
}
