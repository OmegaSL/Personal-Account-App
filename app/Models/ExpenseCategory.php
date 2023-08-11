<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'expense_categories';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'status',
    ];

    // set slug automatically on create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($expenseCategory) {
            $expenseCategory->slug = Str::slug($expenseCategory->name);
        });
    }

    /**
     * Get the user that owns the ExpenseCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all of the expenses for the ExpenseCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'expense_category_id', 'id');
    }
}
