<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $expenseCategories = \App\Models\ExpenseCategory::pluck('id')->toArray();
        $users = \App\Models\User::pluck('id')->toArray();

        return [
            'expense_category_id' => $this->faker->randomElement($expenseCategories),
            'user_id' => $this->faker->randomElement($users),
            'title' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->boolean,
        ];
    }
}
