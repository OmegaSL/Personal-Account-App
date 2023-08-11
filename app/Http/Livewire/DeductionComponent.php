<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class DeductionComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $dateFrom;
    public $dateTo;

    public $deduction_id;
    public $deduction_name;
    public $deduction_description;
    public $deduction_frequency;
    public $deduction_period;
    public $deduction_amount;
    public $deduction_start_date;
    public $deduction_end_date;
    public $deduction_status = 1;

    public $deduction_histories = [];
    public $view_deduction = null;

    public function render()
    {
        return view('livewire.deduction-component', [
            'deductions' => \App\Models\Deduction::query()
                ->latest()
                ->where('user_id', auth()->id())
                ->searchDateRange($this->dateFrom, $this->dateTo)
                ->paginate(10),
        ])->extends('layouts.app');
    }

    public function resetFilter()
    {
        $this->dateFrom = null;
        $this->dateTo = null;
    }

    // reset input fields
    public function resetInputFields()
    {
        $this->deduction_id = '';
        $this->deduction_name = '';
        $this->deduction_description = '';
        $this->deduction_frequency = '';
        $this->deduction_period = '';
        $this->deduction_amount = '';
        $this->deduction_start_date = '';
        $this->deduction_end_date = '';
        $this->deduction_status = '';

        $this->deduction_histories = [];
        $this->view_deduction = null;
    }

    // view deduction
    public function viewDeduction($id)
    {
        $this->deduction_histories = \App\Models\DeductionHistory::where('deduction_id', $id)->get();
        $this->view_deduction = \App\Models\Deduction::findOrFail($id);
    }

    // validate rules
    protected $rules = [
        'deduction_name' => 'required|string',
        'deduction_description' => 'nullable|string',
        'deduction_frequency' => 'required|string',
        'deduction_period' => 'required',
        'deduction_amount' => 'required|numeric|min:0',
        'deduction_start_date' => 'required|date',
        'deduction_end_date' => 'required|after_or_equal:deduction_start_date',
        'deduction_status' => 'required|boolean',
    ];

    // add deduction
    public function addDeduction()
    {
        $this->validate();
        // dd($this->all());

        // check if user has enough basic_balance
        if (auth()->user()->basic_balance < ($this->deduction_amount * $this->deduction_period)) {
            toastr()->info('You do not have enough balance to complete this deduction.');
            return;
        }

        $deduction = new \App\Models\Deduction();
        $deduction->user_id = auth()->user()->id;
        $deduction->name = $this->deduction_name;
        $deduction->description = $this->deduction_description;
        $deduction->frequency = $this->deduction_frequency;
        $deduction->period = $this->deduction_period;
        $deduction->amount = $this->deduction_amount;
        $deduction->overall_total_amount = $this->deduction_amount * $this->deduction_period;
        $deduction->start_date = $this->deduction_start_date;
        $deduction->end_date = $this->deduction_end_date;
        $deduction->status = $this->deduction_status;
        $deduction->save();

        // deduct overall_total_amount from user basic_balance
        $user = \App\Models\User::find(auth()->user()->id);
        $user->basic_balance = $user->basic_balance - $deduction->overall_total_amount;
        $user->save();

        $this->resetInputFields();
        $this->dispatchBrowserEvent('deductionStore'); // Close model to using to jquery

        toastr()->success('Deduction successfully added.');
        return;
    }

    public function editDeduction($id)
    {
        $deduction = \App\Models\Deduction::findOrFail($id);
        $this->deduction_id = $id;
        $this->deduction_name = $deduction->name;
        $this->deduction_description = $deduction->description;
        $this->deduction_frequency = $deduction->frequency;
        $this->deduction_period = $deduction->period;
        $this->deduction_amount = $deduction->amount;
        $this->deduction_start_date = $deduction->start_date->format('Y-m-d');
        $this->deduction_end_date = $deduction->end_date->format('Y-m-d');
        $this->deduction_status = $deduction->status;
    }

    public function updateDeduction()
    {
        $this->validate();

        if ($this->deduction_id) {
            $deduction = \App\Models\Deduction::find($this->deduction_id);
            $deduction->update([
                'name' => $this->deduction_name,
                'description' => $this->deduction_description,
                'frequency' => $this->deduction_frequency,
                // 'period' => $this->deduction_period,
                // 'amount' => $this->deduction_amount,
                // 'overall_total_amount' => $this->deduction_amount * $this->deduction_period,
                // 'start_date' => $this->deduction_start_date,
                'end_date' => $this->deduction_end_date,
                'status' => $this->deduction_status,
            ]);
            $this->resetInputFields();
            $this->dispatchBrowserEvent('deductionUpdate'); // Close model to using to jquery
        } else {
            toastr()->error('Record not found to update. Close modal and try again.');
            return;
        }

        toastr()->success('Deduction successfully updated.');
        return;
    }

    public function deleteDeduction($id)
    {
        if ($id) {
            \App\Models\Deduction::where('id', $id)->delete();
            toastr()->success('Deduction successfully deleted.');
        }
    }

    public function receiveDeduction($id)
    {
        if ($id) {
            $deduction = \App\Models\Deduction::query()
                ->where('id', $id)
                ->where('receive_status', 0)
                ->first();
            $deduction->update([
                'receive_status' => 1,
            ]);

            // add overall_total_amount to user basic_balance
            $user = \App\Models\User::find(auth()->user()->id);
            $user->basic_balance = $user->basic_balance + $deduction->overall_total_amount;
            $user->save();

            toastr()->success('Deduction successfully received.');
        }
    }
}
