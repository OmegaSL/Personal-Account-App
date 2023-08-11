<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'expense_category_id',
        'user_id',
        'title',
        'amount',
        'description',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\ExpenseCategory>
     */
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
