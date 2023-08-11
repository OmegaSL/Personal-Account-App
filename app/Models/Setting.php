<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    //table name
    protected $table = 'settings';

    protected $fillable = [
        'site_name',
        'site_email',
        'site_phone',
        'site_address',
        'about_us',
        'mission',
        'vision',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'whatsapp_contact',
        'telegram_contact',
        'currency',
        'transaction_fee',
        'saving_withdrawal_limit',
        'withdrawal_limit_period',
    ];
}
