<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WithdrawalComponent extends Component
{
    public $amount = 0;
    public $payment_method;
    public $bank_name;
    public $balance_type = 'basic_balance';

    public function render()
    {
        return view('livewire.withdrawal-component', [
            'payment_methods' => \App\Models\PaymentMethod::query()
                ->where('user_id', auth()->id())
                ->where('account_type', '!=', 'card')
                ->where('status', 1)
                ->get(),
        ])->extends('layouts.app');
    }

    public function withdrawal()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required',
            'bank_name' => 'required',
            'balance_type' => 'required|in:basic_balance,saving_balance',
        ]);

        // check if user has enough balance
        if ($this->balance_type == 'basic_balance' && auth()->user()->basic_balance < $this->amount) {
            toastr()->error('Insufficient balance in your basic account');
            return;
        } elseif ($this->balance_type == 'saving_balance' && auth()->user()->saving_balance < $this->amount) {
            toastr()->error('Insufficient balance in your saving account');
            return;
        }

		$setting = \App\Models\Setting::query()->first();

        // check withdrawal limit for saving account per withdrawal_limit_period settings
        if ($this->balance_type == 'saving_balance') {
            $withdrawal_limit_period = $setting->withdrawal_limit_period ?? 1;
            $saving_withdrawal_limit = $setting->saving_withdrawal_limit ?? 1000;
            // cannot withdraw from saving account more than $saving_withdrawal_limit per withdrawal_limit_period(this is in days)
//            $withdrawal_sum = \App\Models\Transaction::query()
//				->where('user_id', auth()->user()->id)
//				->where('type', 'withdrawal')
//				->where('balance_type', 'saving_balance')
//				->where('created_at', '>=', now()->subDays($withdrawal_limit_period))
//				->sum('amount');
//			if ($withdrawal_sum >= $saving_withdrawal_limit) {
//				toastr()->error('You have reached your withdrawal limit for this period in your saving account');
//				return;
//            }

	        // the amount should not be more than the withdrawal limit
	        if ($this->amount > $saving_withdrawal_limit) {
		        toastr()->error('You cannot withdraw more than ' . $setting->currency . $saving_withdrawal_limit . ' from your saving account per withdrawal');
		        return;
	        }

			// cannot withdraw from saving account more than $withdrawal_limit_period(this is in days) times per day
	        $withdrawal_count = \App\Models\Transaction::query()
				->where('user_id', auth()->user()->id)
				->where('type', 'withdrawal')
				->where('balance_type', 'saving_balance')
				->where('created_at', '>=', now()->subDays($withdrawal_limit_period))
				->count();
			if ($withdrawal_count >= $withdrawal_limit_period) {
				toastr()->error('You have reached your withdrawal limit for this period');
				return;
			}
        }

        $transaction = new \App\Models\Transaction();
        $transaction->user_id = auth()->user()->id;
        $transaction->amount = $this->amount;
        $transaction->payment_method_id = $this->payment_method;
        $transaction->reference = 'dep' . time() . rand(100, 999);
        $transaction->type = 'withdrawal';
        $transaction->fee = $this->amount * ($setting->transaction_fee ?? (0 / 100));
        $transaction->note = 'Withdrawal request';
        $transaction->balance_type = $this->balance_type; // 'basic_balance' or 'saving_balance
        $transaction->status = 'pending';
        $transaction->save();

        // subtract user balance here
        if ($this->balance_type == 'basic_balance') {
            auth()->user()->basic_balance -= $this->amount + $transaction->fee;
        } elseif ($this->balance_type == 'saving_balance') {
            auth()->user()->saving_balance -= $this->amount + $transaction->fee;
        }
        auth()->user()->save();

        return redirect()->route('withdrawal.success', $transaction->reference)->with('success', 'Withdrawal request sent successfully');
    }
}
