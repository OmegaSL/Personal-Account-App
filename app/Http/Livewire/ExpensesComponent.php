<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ExpensesComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $category_name;

    public $expense_id;
    public $expense_category;
    public $title;
    public $amount;
    public $description;
    public $status = 1;

    public $dateFrom;
    public $dateTo;

    public function render()
    {
        return view('livewire.expenses-component', [
            'expenses' => \App\Models\Expense::query()
                ->with(['expenseCategory'])
                ->latest()
                ->searchDateRange($this->dateFrom, $this->dateTo)
                ->where('user_id', auth()->user()->id)
                ->paginate(10),
            'categories' => \App\Models\ExpenseCategory::query()
                ->latest('name')
                // ->where('user_id', auth()->user()->id)
                ->where('status', 1)
                ->get(),
        ])->extends('layouts.app');
    }

    // reset fields
    public function resetFields()
    {
        $this->expense_category = '';
        $this->title = '';
        $this->amount = '';
        $this->description = '';

        $this->category_name = '';
        $this->dateFrom = '';
        $this->dateTo = '';
    }

    public function storeCategory()
    {
        $this->validate([
            'category_name' => 'required|string',
        ]);

        $category = new \App\Models\ExpenseCategory();
        $category->user_id = auth()->user()->id;
        $category->name = $this->category_name;
        $category->save();

        $this->resetFields();

        toastr()->success('Category Added Successfully');
        return;
    }

    public function storeExpenses()
    {
        $this->validate([
            'expense_category' => 'required|exists:expense_categories,id',
            'title' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $expense = new \App\Models\Expense();
        $expense->user_id = auth()->user()->id;
        $expense->expense_category_id = $this->expense_category;
        $expense->title = $this->title;
        $expense->amount = $this->amount;
        $expense->description = $this->description;
        $expense->status = 1;
        $expense->save();

        $this->resetFields();

        toastr()->success('Expenses Added Successfully');
        return;
    }

    public function editExpense($id)
    {
        $expense = \App\Models\Expense::find($id);
        $this->expense_id = $expense->id;
        $this->expense_category = $expense->expense_category_id;
        $this->title = $expense->title;
        $this->amount = $expense->amount;
        $this->description = $expense->description;
    }

    public function updateExpense()
    {
        $this->validate([
            'expense_category' => 'required|exists:expense_categories,id',
            'title' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $expense = \App\Models\Expense::find($this->expense_id);
        $expense->expense_category_id = $this->expense_category;
        $expense->title = $this->title;
        $expense->amount = $this->amount;
        $expense->description = $this->description;
        $expense->save();

        $this->resetFields();

        toastr()->success('Expenses Updated Successfully');
        return;
    }

    public function deleteExpense($id)
    {
        $expense = \App\Models\Expense::find($id);
        $expense->delete();

        toastr()->success('Category Deleted Successfully');
        return;
    }
}
