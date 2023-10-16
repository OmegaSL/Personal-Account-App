<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    // table name
    protected $table = 'payment_methods';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'account_name',
        'account_type',
        'account_number',
        'bank_name',
        'bank_country',
        'momo_provider',
        'card_number',
        'card_type',
        'card_expiry',
        'card_cvv',
        'card_holder',
        'status',
    ];

    // get account_type attribute
    public function getAccountTypeAttribute($value): string
    {
        return Str::headline($value);
    }

    /**
     * Get the user that owns the PaymentMethod
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all the transactions for the PaymentMethod
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payment_method_id', 'id');
    }
}
