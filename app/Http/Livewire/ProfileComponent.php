<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileComponent extends Component
{
    use WithFileUploads;

    public $user;
    public $world_countries;

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $avatar_url;
    public $address;
    public $state;
    public $city;
    public $country;
    public $postal_code;
    public $birth_date;

    public $current_password;
    public $new_password;
    public $confirm_password;

    public function mount()
    {
        $this->user = auth()->user();

        $filePath = storage_path('app/countries.json');

        // Check if the file exists
        if (!file_exists($filePath)) {
            // Handle the case when the file is not found
            toastr()->error('JSON file not found!', 404);
            return;
        }

        // Read the contents of the JSON file as a string
        $jsonString = file_get_contents($filePath);

        // Parse the JSON string into a PHP array
        $dataArray = json_decode($jsonString, true);

        // Check if JSON decoding was successful
        if ($dataArray === null) {
            // Handle the case when JSON parsing fails
            return response()->json(['error' => 'Invalid JSON format'], 500);
        }

        $this->world_countries = $dataArray;

        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->address = $this->user->address;
        $this->state = $this->user->state;
        $this->city = $this->user->city;
        foreach ($dataArray as $key => $value) {
            if ($value['alpha2'] == $this->user->country) {
                $this->country = $value['alpha2'];
            }
        }
        $this->postal_code = $this->user->postal_code;
        $this->birth_date = $this->user->birth_date;
    }

    public function render()
    {
        return view('livewire.profile-component')->extends('layouts.app');
    }

    public function updateProfile()
    {
        $this->validate([
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'phone' => 'required|min:10|max:15',
            'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'address' => 'required|min:3|max:255',
            'state' => 'required|min:3|max:50',
            'city' => 'required|min:3|max:50',
            'country' => 'required|min:2|max:2',
            'postal_code' => 'required|min:3|max:10',
            'birth_date' => 'required|date',
        ]);

        if ($this->avatar_url) {
            $imageName = $this->avatar_url->store('avatars', 'public');
        }

        $this->user->first_name = $this->first_name;
        $this->user->last_name = $this->last_name;
        $this->user->phone = $this->phone;
        $this->user->avatar_url = isset($imageName) ? $imageName : $this->user->avatar_url;
        $this->user->address = $this->address;
        $this->user->state = $this->state;
        $this->user->city = $this->city;
        $this->user->country = $this->country;
        $this->user->postal_code = $this->postal_code;
        $this->user->birth_date = $this->birth_date;

        $this->user->save();

        toastr()->success('Profile updated successfully!');
        return;
    }

    // update email and set email_verified_at to null if email is changed
    public function updateEmail()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ]);

        $email_check = $this->email != $this->user->email ? true : false;

        if ($email_check) {
            $otp_code = rand(100000, 999999);

            $this->user->email = $this->email;
            $this->user->email_verified_at = null;
            $this->user->otp_code = $otp_code;
            $this->user->save();

            $data = [
                'name' => $this->user->name,
                'otp_code' => $otp_code,
            ];

            Mail::send('emails.verify-account-mail', $data, function ($message) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->sender(config('mail.from.address'), config('mail.from.name'));
                $message->to($this->user->email, $this->user->name);
                $message->subject('OTP Code for Verification');
            });

            return redirect()->route('verification.notice')->with('message', 'Verify your email address');
        }

        toastr()->success('Email same as before, no changes made!');
        return;
    }

    // edit phone number
    public function editPhone()
    {
        $this->validate([
            'phone' => 'required|between:10,12',
        ]);

        $this->user->phone = $this->phone;

        $this->user->save();

        toastr()->success('Phone number updated successfully!');
        return;
    }

    // update password
    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8|same:confirm_password',
        ]);

        if (!Hash::check($this->current_password, $this->user->password)) {
            toastr()->error('Current password is incorrect!');
            return;
        }

        $this->user->password = bcrypt($this->new_password);

        $this->user->save();

        toastr()->success('Password updated successfully!');
        return;
    }
}
