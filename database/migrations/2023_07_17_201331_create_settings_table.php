<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->string('site_email');
            $table->string('site_email2')->nullable();
            $table->string('site_phone');
            $table->string('site_phone2')->nullable();
            $table->string('site_address');
            $table->longText('about_us')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('whatsapp_contact')->nullable();
            $table->string('telegram_contact')->nullable();
            $table->string('currency')->default('₵');
            $table->float('transaction_fee')->default(0);
            $table->integer('saving_withdrawal_limit')->default(0);
            $table->integer('withdrawal_limit_period')->default(0)->comment('in days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
