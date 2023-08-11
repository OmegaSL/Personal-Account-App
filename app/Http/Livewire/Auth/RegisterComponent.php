<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterComponent extends Component
{
    public $first_name;
    public $last_name;
    public $name;
    public $email;
    public $phone;
    public $birth_date;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
    }

    public function register()
    {
        $validator = Validator::make(
            [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'birth_date' => $this->birth_date,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ],
            [
                'first_name' => 'required|min:3|max:50',
                'last_name' => 'required|min:3|max:50',
                'name' => 'required|min:3|max:50',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|digits_between:10,12|unique:users,phone',
                'birth_date' => 'required|date',
                'password' => 'required|min:6|same:password_confirmation',
                'password_confirmation' => 'required|min:6|same:password',
            ]
        );

        if ($validator->fails()) {
            toastr()->error($validator->messages()->first());
            return;
        }

        $otp_code = rand(100000, 999999);

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
            'password' => Hash::make($this->password),
            'otp_code' => $otp_code,
        ]);

        $user->assignRole('normal_user');

        $data = [
            'name' => $this->name,
            'otp_code' => $otp_code,
        ];

        Mail::send('emails.verify-account-mail', $data, function ($message) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->sender(config('mail.from.address'), config('mail.from.name'));
            $message->to($this->email, $this->name);
            $message->subject('OTP Code for Verification');
        });

        auth()->login($user);

        return redirect()->route('verification.notice')->with('success', 'Registration successful, an OTP code has been sent to your email address for verification.');
    }

    public function render()
    {
        return view('livewire.auth.register-component')->extends('layouts.auth');
    }
}
