<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faqCategories = \App\Models\FaqCategory::pluck('id')->toArray();

        return [
            'faq_category_id' => $this->faker->randomElement($faqCategories),
            'question' => $this->faker->sentence,
            'answer' => $this->faker->paragraph,
            'status' => $this->faker->boolean(),
        ];
    }
}
