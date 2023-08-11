<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FaqCategory extends Model
{
    use HasFactory, SoftDeletes;

    // table name
    protected $table = 'faq_categories';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // set slug automatically on create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($faqCategory) {
            $faqCategory->slug = Str::slug($faqCategory->name);
        });
    }

    /**
     * Get all of the faqs for the FaqCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'faq_category_id', 'id');
    }
}
