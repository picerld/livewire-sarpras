<?php

namespace App\Livewire\Components\Unit;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public function render() {
        $user = Auth::user();

        return view('livewire.components.unit.sidebar', [
            "user" => $user
        ]);
    }
}
