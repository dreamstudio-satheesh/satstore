<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard') // The view for this component
            ->layout('layouts.main'); // Specifies the layout
    }
}
