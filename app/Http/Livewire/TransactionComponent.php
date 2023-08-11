<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class TransactionComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $user;
    public $transaction_details = null;
    public $filterBy;
    public $dateFrom;
    public $dateTo;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.transaction-component', [
            'transactions' => Transaction::with(['payment_method'])
                ->latest()
                ->searchDateRange($this->dateFrom, $this->dateTo)
                ->where('status', 'LIKE', '%' . $this->filterBy . '%')
                ->paginate(10)
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
