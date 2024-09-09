<?php

namespace App\Livewire\Components\Admin;

use Livewire\Component;

class Navbar extends Component
{
    // navbar
    public $brandName = 'Sarpras';
    public $notif;

    public function mount($notif): void
    {
        $this->notif = count($notif);
    }

    public function render() {
        return view('livewire.components.admin.navbar');
    }
}
