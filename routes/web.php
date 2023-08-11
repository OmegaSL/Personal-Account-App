<?php

use App\Http\Controllers\PaymentController;
use App\Http\Livewire\AboutUsComponent;
use App\Http\Livewire\HomeComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\LoginComponent;
use App\Http\Livewire\Auth\RegisterComponent;
use App\Http\Livewire\Auth\AccountVerifyComponent;
use App\Http\Livewire\ContactUsComponent;
use App\Http\Livewire\DeductionComponent;
use App\Http\Livewire\DepositComponent;
use App\Http\Livewire\ExpensesComponent;
use App\Http\Livewire\HelpComponent;
use App\Http\Livewire\ProfileAccountComponent;
use App\Http\Livewire\ProfileComponent;
use App\Http\Livewire\TransactionComponent;
use App\Http\Livewire\WithdrawalComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// Route::get('/', [HomeController::class, 'index']);
Route::get('/login', LoginComponent::class)->name('login');
Route::get('/register', RegisterComponent::class)->name('register');
Route::get('/verify-account', AccountVerifyComponent::class)->name('verification.notice');

Route::get('/about-us', AboutUsComponent::class)->name('about-us');

Route::group(['middleware' => ['auth', 'account.verify']], function () {
    Route::get('/dashboard', HomeComponent::class)->name('home');
    Route::get('/transactions', TransactionComponent::class)->name('transactions');
    Route::get('/deposit-withdrawal', DepositComponent::class)->name('deposit');
    Route::get('/deposit-success/{reference}', [PaymentController::class, 'deposit_success'])->name('deposit.success');
    Route::get('/withdrawal-deposit', WithdrawalComponent::class)->name('withdrawal');
    Route::get('/withdrawal-success/{reference}', [PaymentController::class, 'withdrawal_success'])->name('withdrawal.success');
    Route::get('/profile', ProfileComponent::class)->name('profile');
    Route::get('/account-profile', ProfileAccountComponent::class)->name('profile-account');
    Route::get('/saving-deduction', DeductionComponent::class)->name('saving-deduction');
    Route::get('/my-expenses', ExpensesComponent::class)->name('user.expenses');

    Route::get('/help', HelpComponent::class)->name('help');
    Route::get('/contact-us', ContactUsComponent::class)->name('contact-us');

    // The callback url after a payment
    Route::get('/rave/callback', [PaymentController::class, 'callback'])->name('callback');
});

// logout route
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
