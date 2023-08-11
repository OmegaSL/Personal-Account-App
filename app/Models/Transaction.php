<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'reference',
        'type',
        'balance_type',
        'amount',
        'fee',
        'note',
        'status',
    ];

    // on create transaction
    public static function boot()
    {
        parent::boot();

        // check if transaction status is changed and is completed or cancelled, then send email to the user
        static::updated(function ($transaction) {
            if ($transaction->isDirty('status')) {
                if ($transaction->status == 'completed' || $transaction->status == 'cancelled' || $transaction->status == 'failed') {
                    $data = [
                        'transaction' => $transaction,
                    ];

                    Mail::send('emails.transaction-mail', $data, function ($message) use ($transaction) {
                        $message->from(config('mail.from.address'), config('mail.from.name'));
                        $message->to($transaction->user->email, $transaction->user->name);
                        $message->subject('Transaction ' . $transaction->status);
                    });
                }
            }
        });
    }

    // get type attribute
    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the payment_method that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
