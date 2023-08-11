<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeductionHistory extends Model
{
    use HasFactory;

    protected $table = 'deduction_histories';

    protected $fillable = [
        'deduction_id',
        'amount',
        'description',
    ];

    /**
     * Get the deduction that owns the DeductionHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deduction(): BelongsTo
    {
        return $this->belongsTo(Deduction::class, 'deduction_id', 'id');
    }
}
