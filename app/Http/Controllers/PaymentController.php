<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Flutterwave\Rave as Flutterwave;

class PaymentController extends Controller
{
    protected $flutterwave;

    public function __construct()
    {
        $this->flutterwave = new Flutterwave();
    }

    public function deposit_success($reference)
    {
        // get transaction details
        $transaction = \App\Models\Transaction::query()
            ->where('reference', $reference)
            ->first();

        return view('livewire.notify.deposit_success', [
            'transaction' => $transaction,
        ]);
    }

    public function withdrawal_success($reference)
    {
        // get transaction details
        $transaction = \App\Models\Transaction::query()
            ->where('reference', $reference)
            ->first();

        return view('livewire.notify.withdrawal_success', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {

        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {

            $transactionID = $this->flutterwave->getTransactionIDFromCallback();
            $data = $this->flutterwave->verifyTransaction($transactionID);

            // dd($data['data']);

            $transaction = new \App\Models\Transaction();
            $transaction->user_id = \App\Models\User::query()->where('email', $data['data']['customer']['email'])->first()->id;
            $transaction->amount = $data['data']['amount'];
            $transaction->payment_method_id = $data['data']['meta']['payment_method_id'];
            $transaction->reference = $data['data']['tx_ref'];
            $transaction->type = 'deposit';
            $transaction->fee = $data['data']['amount'] * \App\Models\Setting::query()->first()->transaction_fee / 100;
            $transaction->note = 'Deposit request';
            $transaction->balance_type = 'basic_balance'; // 'basic_balance' or 'saving_balance
            $transaction->status = 'pending';
            $transaction->save();

            // update user basic balance
            $user = \App\Models\User::query()->where('email', $data['data']['customer']['email'])->first();
            $user->basic_balance = $user->basic_balance + $data['data']['amount'];
            $user->save();

            return redirect()->route('deposit.success', $transaction->reference)->with('success', 'Deposit request sent successfully');
        } elseif ($status ==  'cancelled') {
            //Put desired action/code after transaction has been cancelled here
            return redirect()->route('deposit')->with('error', 'Transaction cancelled');
        } else {
            //Put desired action/code after transaction has failed here
            return redirect()->route('deposit')->with('error', 'Transaction failed');
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }
}
