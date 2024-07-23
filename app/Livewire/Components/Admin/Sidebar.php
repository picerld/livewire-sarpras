<?php

namespace App\Livewire\Components\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public function render() {
        $user = Auth::user();

        return view('livewire.components.admin.sidebar', [
            "user" => $user
        ]);
    }
}
