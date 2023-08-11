<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;

    // table name
    protected $table = 'faqs';

    /**
     * @var string[]
     */
    protected $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'status',
        'order',
    ];

    /**
     * Get the faqCategory that owns the Faq
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faqCategory(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id', 'id');
    }
}
