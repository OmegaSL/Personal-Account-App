<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class LoginComponent extends Component
{
    public $email;
    public $password;
    public $remember_me = false;

    public function mount()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
    }

    public function login()
    {
        $validator = Validator::make(
            [
                'email' => $this->email,
                'password' => $this->password,
            ],
            [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6',
            ]
        );

        if ($validator->fails()) {
            toastr()->error($validator->messages()->first());
            return;
        }

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            // if (!auth()->user()->email_verified_at) {
            //     toastr()->info('Your account is not verified');
            //     return redirect()->route('verification.notice');
            // }

            toastr()->success('Login successful');
            return redirect()->intended('/dashboard');
        }

        toastr()->error('Invalid credentials');
        return;
    }

    public function render()
    {
        return view('livewire.auth.login-component')->extends('layouts.auth');
    }
}
