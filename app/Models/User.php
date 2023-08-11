<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\HasName;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'avatar_url',
        'address',
        'state',
        'city',
        'country',
        'postal_code',
        'birth_date',
        'basic_balance',
        'saving_balance',
        'status',
        'password',
        'otp_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canAccessFilament(): bool
    {
        return $this->hasRole('super_admin') && $this->hasVerifiedEmail();
    }

    public function getFilamentName(): string
    {
        return $this->first_name != null ? "{$this->first_name} {$this->last_name}" : $this->name;
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name != null ? "{$this->first_name} {$this->last_name}" : $this->name;
    }

    // if user basic balance is greater than 1000 or 10000 or 100000 or 1000000 or 10000000, convert to k, m, b, t, q
    public function convertBalance($value): string
    {
        $basic_balance = $value;

        if ($basic_balance >= 1000 && $basic_balance < 1000000) {
            $basic_balance = number_format($basic_balance / 1000) . 'K';
        } elseif ($basic_balance >= 1000000 && $basic_balance < 1000000000) {
            $basic_balance = number_format($basic_balance / 1000000) . 'M';
        } elseif ($basic_balance >= 1000000000 && $basic_balance < 1000000000000) {
            $basic_balance = number_format($basic_balance / 1000000000) . 'B';
        } elseif ($basic_balance >= 1000000000000 && $basic_balance < 1000000000000000) {
            $basic_balance = number_format($basic_balance / 1000000000000) . 'T';
        }

        return $basic_balance;
    }

    /**
     * Get all of the paymentMethods for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class, 'user_id', 'id');
    }

    /**
     * Get all of the transactions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    /**
     * Get all of the deductions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deductions(): HasMany
    {
        return $this->hasMany(Deduction::class, 'user_id', 'id');
    }

    /**
     * Get all of the deduction_histories for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function deduction_histories(): HasManyThrough
    {
        return $this->hasManyThrough(DeductionHistory::class, Deduction::class);
    }

    /**
     * Get all of the expenses for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'user_id', 'id');
    }
}
