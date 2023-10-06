<?php

namespace App\Admin\Pages;

use Closure;
use Filament\Forms;
use App\Models\Setting;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput\Mask;

class Settings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $setting;

    public $site_name;
    public $site_email;
    public $site_phone;
    public $site_address;
     public $site_logo;
     public $site_favicon;
    public $about_us;
    public $mission;
    public $vision;

    public $site_description;

    public $facebook_url;
    public $twitter_url;
    public $instagram_url;
    public $linkedin_url;
    public $youtube_url;
    public $whatsapp_contact;
    public $telegram_contact;

    public $currency;
    public $transaction_fee;
    public $saving_withdrawal_limit;
    public $withdrawal_limit_period;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'admin.pages.settings';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'General Settings';

    protected static function getNavigationGroup(): ?string
    {
        return __('Manage Site');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('page_Settings');
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->can('page_Settings'), 403);

        $this->setting = Setting::latest()->first();

        $this->site_name = $this->setting->site_name;
        $this->site_email = $this->setting->site_email;
        $this->site_phone = $this->setting->site_phone;
        $this->site_phone2 = $this->setting->site_phone2;
        $this->site_address = $this->setting->site_address;
         $this->site_logo = $this->setting->site_logo;
         $this->site_favicon = $this->setting->site_favicon;
        $this->about_us = $this->setting->about_us;
        $this->mission = $this->setting->mission;
        $this->vision = $this->setting->vision;

        $this->site_description = $this->setting->site_description;

        $this->facebook_url = $this->setting->facebook_url;
        $this->twitter_url = $this->setting->twitter_url;
        $this->instagram_url = $this->setting->instagram_url;
        $this->linkedin_url = $this->setting->linkedin_url;
        $this->youtube_url = $this->setting->youtube_url;
        $this->whatsapp_contact = $this->setting->whatsapp_contact;
        $this->telegram_contact = $this->setting->telegram_contact;

        $this->currency = $this->setting->currency;
        $this->transaction_fee = $this->setting->transaction_fee;
        $this->saving_withdrawal_limit = $this->setting->saving_withdrawal_limit;
        $this->withdrawal_limit_period = $this->setting->withdrawal_limit_period;
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('site_name')->required(),
                    Forms\Components\TextInput::make('site_email')->required(),
                    Forms\Components\TextInput::make('site_phone')->required(),
                    Forms\Components\TextInput::make('site_phone2'),
                    Forms\Components\TextInput::make('site_address')->required()->columnSpanFull(),
                    Forms\Components\FileUpload::make('site_logo')->image()->columnSpanFull(),
                    Forms\Components\FileUpload::make('site_favicon')->image()->columnSpanFull(),
                    Forms\Components\Textarea::make('about_us')->required()->columnSpanFull(),
                    Forms\Components\Textarea::make('mission')->required(),
                    Forms\Components\Textarea::make('vision')->required(),
                ])->columns(2),
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Textarea::make('site_description'),
                ]),
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('facebook_url'),
                    Forms\Components\TextInput::make('twitter_url'),
                    Forms\Components\TextInput::make('instagram_url'),
                    Forms\Components\TextInput::make('linkedin_url'),
                    Forms\Components\TextInput::make('youtube_url'),
                    Forms\Components\TextInput::make('whatsapp_contact'),
                    Forms\Components\TextInput::make('telegram_contact'),
                ])->columns(2),
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('currency')->required(),
                    Forms\Components\TextInput::make('transaction_fee')->numeric()->minValue(0)->required(),
                    Forms\Components\TextInput::make('saving_withdrawal_limit')->numeric()->minValue(0)->required(),
                    Forms\Components\TextInput::make('withdrawal_limit_period')->numeric()->minValue(0)->required(),
                ])->columns(2),
        ];
    }

    public function submit(): void
    {
        // dd($this->site_title);
        // Setting::updateOrCreate($this->form->getState());
        if ($this->setting) {
            $this->setting->update($this->form->getState());
        } else {
            $this->setting = Setting::create($this->form->getState());
        }

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
}
