<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProfileAccountComponent extends Component
{
    public $user;

    public $payment_method_id;
    public $account_name;
    public $account_type;
    public $bank_name;
    public $bank_country;
    public $momo_provider;
    public $account_number;
    public $card_number;
    public $card_type = 'visa';
    public $card_expiry;
    public $card_cvv;
    public $card_holder;
    public $status;
    public $world_countries;

    public $momo_update_mode = false;

    public function mount()
    {
        $this->user = auth()->user();

        $filePath = storage_path('app/countries.json');

        // Check if the file exists
        if (!file_exists($filePath)) {
            // Handle the case when the file is not found
            toastr()->error('JSON file not found!', 404);
            return;
        }

        // Read the contents of the JSON file as a string
        $jsonString = file_get_contents($filePath);

        // Parse the JSON string into a PHP array
        $dataArray = json_decode($jsonString, true);

        // Check if JSON decoding was successful
        if ($dataArray === null) {
            // Handle the case when JSON parsing fails
            return response()->json(['error' => 'Invalid JSON format'], 500);
        }

        $this->world_countries = $dataArray;
    }

    public function render()
    {
        return view('livewire.profile-account-component', [
            'card_payment_methods' => \App\Models\PaymentMethod::query()
                ->where('account_type', 'card')
                ->where('user_id', auth()->id())
                ->get(),
            'mobile_money_payment_methods' => \App\Models\PaymentMethod::query()
                ->where('account_type', 'mobile_money')
                ->where('user_id', auth()->id())
                ->get(),
            'bank_payment_methods' => \App\Models\PaymentMethod::query()
                ->where('account_type', 'bank')
                ->where('user_id', auth()->id())
                ->get(),
        ])->extends('layouts.app');
    }

    // reset fields
    public function resetFields()
    {
        $this->reset([
            'payment_method_id',
            'account_name',
            'account_type',
            'bank_name',
            'bank_country',
            'account_number',
            'card_number',
            'card_type',
            'card_expiry',
            'card_cvv',
            'card_holder',
            'momo_update_mode',
        ]);
    }

    // add card details
    public function addCardDetails()
    {
        $this->validate([
            // 'account_type' => 'required|in:card,mobile_money',
            'card_number' => 'required|numeric',
            'card_type' => 'required|in:visa,mastercard',
            'card_expiry' => 'required|date_format:m/y',
            'card_cvv' => 'required|numeric|digits:3',
            'card_holder' => 'required|string',
        ]);

        $payment_method = new \App\Models\PaymentMethod();
        $payment_method->user_id = auth()->id();
        $payment_method->account_type = 'card';
        $payment_method->card_number = $this->card_number;
        $payment_method->card_type = $this->card_type;
        $payment_method->card_expiry = $this->card_expiry;
        $payment_method->card_cvv = $this->card_cvv;
        $payment_method->card_holder = $this->card_holder;
        $payment_method->save();

        $this->resetFields();

        toastr()->success('Card details added successfully.');
        return;
    }

    // edit card details
    public function editCardDetails($id)
    {
        $payment_method = \App\Models\PaymentMethod::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$payment_method) {
            toastr()->error('Card details not found.');
            return;
        }

        $this->payment_method_id = $payment_method->id;
        $this->account_type = $payment_method->account_type;
        $this->card_number = $payment_method->card_number;
        $this->card_type = $payment_method->card_type;
        $this->card_expiry = $payment_method->card_expiry;
        $this->card_cvv = $payment_method->card_cvv;
        $this->card_holder = $payment_method->card_holder;
    }

    // update card details
    public function updateCardDetails()
    {
        $this->validate([
            // 'account_type' => 'required|in:card,mobile_money',
            'card_number' => 'required|numeric',
            'card_type' => 'required|in:visa,mastercard',
            'card_expiry' => 'required|date_format:m/y',
            'card_cvv' => 'required|numeric|digits:3',
            'card_holder' => 'required|string',
        ]);

        $payment_method = \App\Models\PaymentMethod::query()
            ->where('id', $this->payment_method_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$payment_method) {
            toastr()->error('Card details not found.');
            return;
        }

        $payment_method->account_type = 'card';
        $payment_method->card_number = $this->card_number;
        $payment_method->card_type = $this->card_type;
        $payment_method->card_expiry = $this->card_expiry;
        $payment_method->card_cvv = $this->card_cvv;
        $payment_method->card_holder = $this->card_holder;
        $payment_method->save();

        $this->resetFields();

        toastr()->success('Card details updated successfully.');
        return;
    }

    // add mobile_money details
    public function addMobileMoneyDetails()
    {
        $this->validate([
            'account_name' => 'required|string',
            'momo_provider' => 'required|string',
            'account_number' => 'required|numeric',
        ]);

        $payment_method = new \App\Models\PaymentMethod();
        $payment_method->user_id = auth()->id();
        $payment_method->account_type = 'mobile_money';
        $payment_method->account_name = $this->account_name;
        $payment_method->momo_provider = $this->momo_provider;
        $payment_method->account_number = $this->account_number;
        $payment_method->save();

        $this->resetFields();

        toastr()->success('Card details added successfully.');
        return;
    }

    // edit mobile_money details
    public function editMobileMoneyDetails($id)
    {
        $payment_method = \App\Models\PaymentMethod::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$payment_method) {
            toastr()->error('Mobile money details not found.');
            return;
        }

        $this->momo_update_mode = true;
        $this->payment_method_id = $payment_method->id;
        $this->account_name = $payment_method->account_name;
        $this->momo_provider = $payment_method->momo_provider;
        $this->account_number = $payment_method->account_number;
    }

    // update mobile_money details
    public function updateMobileMoneyDetails()
    {
        $this->validate([
            'account_name' => 'required|string',
            'momo_provider' => 'required|string',
            'account_number' => 'required|numeric',
        ]);

        $payment_method = \App\Models\PaymentMethod::query()
            ->where('id', $this->payment_method_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$payment_method) {
            toastr()->error('Mobile money details not found.');
            return;
        }

        $payment_method->account_type = 'mobile_money';
        $payment_method->account_name = $this->account_name;
        $payment_method->momo_provider = $this->momo_provider;
        $payment_method->account_number = $this->account_number;
        $payment_method->save();

        $this->resetFields();
        $this->momo_update_mode = false;

        toastr()->success('Mobile money details updated successfully.');
        return;
    }

    // add bank account details
    public function addBankAccountDetails()
    {
        $this->validate([
            'bank_name' => 'required|string',
            'bank_country' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|numeric',
        ]);

        $payment_method = new \App\Models\PaymentMethod();
        $payment_method->user_id = auth()->id();
        $payment_method->account_type = 'bank';
        $payment_method->bank_name = $this->bank_name;
        $payment_method->bank_country = $this->bank_country;
        $payment_method->account_name = $this->account_name;
        $payment_method->account_number = $this->account_number;
        $payment_method->save();

        $this->resetFields();

        toastr()->success('Bank account details added successfully.');
        return;
    }

    // edit bank account details
    public function editBankAccountDetails($id)
    {
        $payment_method = \App\Models\PaymentMethod::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$payment_method) {
            toastr()->error('Bank account details not found.');
            return;
        }

        $this->payment_method_id = $payment_method->id;
        $this->bank_name = $payment_method->bank_name;
        $this->bank_country = $payment_method->bank_country;
        $this->account_name = $payment_method->account_name;
        $this->account_number = $payment_method->account_number;
        $this->status = $payment_method->status;
    }

    // update bank account details
    public function updateBankAccountDetails()
    {
        $this->validate([
            'bank_name' => 'required|string',
            'bank_country' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|numeric',
        ]);

        $payment_method = \App\Models\PaymentMethod::query()
            ->where('id', $this->payment_method_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$payment_method) {
            toastr()->error('Bank account details not found.');
            return;
        }

        $payment_method->account_type = 'bank';
        $payment_method->bank_name = $this->bank_name;
        $payment_method->bank_country = $this->bank_country;
        $payment_method->account_name = $this->account_name;
        $payment_method->account_number = $this->account_number;
        $payment_method->save();

        $this->resetFields();

        toastr()->success('Bank account details updated successfully.');
        return;
    }

    // delete payment method
    public function deletePaymentMethod($id)
    {
        $payment_method = \App\Models\PaymentMethod::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
        // dd($payment_method);

        if (!$payment_method) {
            toastr()->error('Payment method not found.');
            return;
        }

        $payment_method->delete();

        toastr()->success('Payment method deleted successfully.');
        return;
    }
}
