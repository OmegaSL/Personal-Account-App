<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeductionHistory>
 */
class DeductionHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $deductions = \App\Models\Deduction::pluck('id')->toArray();

        return [
            'deduction_id' => $this->faker->randomElement($deductions),
            'amount' => $this->faker->randomFloat(2, 0, 100000),
            'description' => $this->faker->text,
        ];
    }
}
