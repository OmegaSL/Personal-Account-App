<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HelpComponent extends Component
{
    public $perPage = 8;

    public function render()
    {
        return view('livewire.help-component', [
            'faqs' => \App\Models\Faq::query()
                ->latest()
                ->where('status', 1)
                ->paginate($this->perPage),
            'all_faq' => \App\Models\Faq::query()
                ->latest()
                ->where('status', 1)
                ->get(),
        ])->extends('layouts.app');
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function loadLess()
    {
        $this->perPage -= 10;
    }
}
