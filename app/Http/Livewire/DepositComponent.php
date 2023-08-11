<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\Flutterwave\Rave as Flutterwave;

class DepositComponent extends Component
{
    public $amount;
    public $payment_method;
    public $bank_name;

    public $reference;

    public function mount()
    {
        //This generates a payment reference
        $this->reference = Flutterwave::generateReference();
    }

    public function render()
    {
        return view('livewire.deposit-component', [
            'payment_methods' => \App\Models\PaymentMethod::query()
                ->where('user_id', auth()->id())
                ->where('account_type', '!=', 'card')
                ->where('status', 1)
                ->get(),
        ])->extends('layouts.app');
    }

    public function deposit()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required',
            'bank_name' => 'required',
        ]);

        $data = [
            'amount' => $this->amount,
            'email' => auth()->user()->email,
            'phone' => auth()->user()->phone,
            'name' => auth()->user()->name,
            'bank_name' => $this->bank_name,
            'reference' => $this->reference,
            'account_type' => \App\Models\PaymentMethod::where('id', $this->payment_method)->first()->account_type,
            'payment_method' => $this->payment_method,
        ];

        // make flutterwave payment here
        return $this->flutterwavePayment($data);
        // return redirect()->route('deposit.success', $transaction->reference)->with('success', 'Deposit request sent successfully');
    }

    public function flutterwavePayment($data)
    {
        // Enter the details of the payment
        $data = [
            'payment_options' => $data['account_type'] == 'mobile_money' ? 'mobilemoneygh' : 'banktransfer',
            'amount' => $data['amount'],
            'email' => $data['email'],
            'tx_ref' => $data['reference'],
            'currency' => "GHS",
            'redirect_url' => route('callback'),
            'customer' => [
                'email' => $data['email'],
                "phone_number" => $data['phone'],
                "name" => $data['name']
            ],
            "customizations" => [
                "title" => "Deposit",
                "description" => "Deposit to your account",
                "logo" => asset('assets/images/logo.png')
            ],
            "meta" => [
                "account_type" => $data['account_type'],
                'bank_name' => $data['bank_name'],
                'reference' => $data['reference'],
                'payment_method_id' => $data['payment_method'],
            ],
        ];

        $payment = new Flutterwave();
        $payment = $payment->initializePayment($data);

        if ($payment['status'] !== 'success') {
            // notify something went wrong
            toastr()->error('Something went wrong, please try again');
            return;
        }

        return redirect($payment['data']['link']);
    }
}
