<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deduction>
 */
class DeductionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = \App\Models\User::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($users),
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->text,
            'frequency' => $this->faker->randomElement(['monthly', 'yearly']),
            'period' => $this->faker->randomDigit(),
            'amount' => $this->faker->randomFloat(2, 0, 100000),
            'overall_total_amount' => $this->faker->randomFloat(2, 0, 100000),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date('Y-m-d', '+1 year'),
            'status' => $this->faker->boolean(),
            'receive_status' => $this->faker->boolean()
        ];
    }
}
