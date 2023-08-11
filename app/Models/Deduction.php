<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deduction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'deductions';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'frequency',
        'period',
        'amount',
        'overall_total_amount',
        'start_date',
        'end_date',
        'status',
        'receive_status',
    ];

    // cast date fields to Carbon
    protected $dates = [
        'start_date',
        'end_date',
    ];

    // set slug automatically on create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($deduction) {
            $deduction->slug = Str::slug($deduction->name);
            $deduction->overall_total_amount = $deduction->period * $deduction->amount;
        });
    }

    // set overall_total_amount automatically on create by multiplying period and amount
    // protected static function booted()
    // {
    //     static::creating(function ($deduction) {
    //         $deduction->overall_total_amount = $deduction->period * $deduction->amount;
    //     });
    // }

    /**
     * Get the user that owns the Deduction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all of the deductionHistories for the Deduction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deductionHistories(): HasMany
    {
        return $this->hasMany(DeductionHistory::class, 'deduction_id', 'id');
    }
}
