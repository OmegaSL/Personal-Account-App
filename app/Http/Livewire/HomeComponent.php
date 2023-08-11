<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HomeComponent extends Component
{
    public $user;
    public $transaction_details = null;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.home-component', [
            'recent_transactions' => $this->user->transactions()->latest()->take(7)->get(),
        ])->extends('layouts.app');
    }

    // reset fields
    public function resetFields()
    {
        $this->transaction_details = null;
    }

    public function show_transaction_details($id)
    {
        $this->transaction_details = $this->user->transactions()->where('id', $id)->first();
        // dd($this->transaction_details);
        // $this->emit('showTransactionDetails', $this->transaction_details);
    }
}
