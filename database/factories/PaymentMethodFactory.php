<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
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
            'account_name' => $this->faker->name,
            'account_type' => $this->faker->randomElement(['bank', 'card', 'mobile_money']),
            'account_number' => $this->faker->bankAccountNumber,
            'bank_name' => $this->faker->randomElement(['Access Bank', 'Agricultural Development Bank', 'Bank of Africa', 'Barclays Bank', 'CAL Bank', 'Ecobank', 'FBNBank', 'Fidelity Bank', 'First Atlantic Bank', 'First National Bank', 'GCB Bank', 'GN Bank', 'Guaranty Trust Bank', 'Republic Bank', 'Societe Generale', 'Stanbic Bank', 'Standard Chartered Bank', 'UMB', 'Universal Merchant Bank', 'Zenith Bank']),
            'bank_country' => $this->faker->country,
            'momo_provider' => $this->faker->randomElement(['MTN', 'Vodafone', 'AirtelTigo']),
            'card_number' => $this->faker->creditCardNumber,
            'card_type' => $this->faker->creditCardType,
            'card_expiry' => $this->faker->creditCardExpirationDate,
            'card_cvv' => $this->faker->randomNumber(3),
            'card_holder' => $this->faker->name,
            'status' => $this->faker->boolean,
        ];
    }
}
