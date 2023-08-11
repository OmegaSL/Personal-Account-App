<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AboutUsComponent extends Component
{
    public function render()
    {
        return view('livewire.about-us-component')->extends('layouts.app');
    }
}
