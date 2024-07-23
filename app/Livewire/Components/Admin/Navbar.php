<?php

namespace App\Livewire\Components\Admin;

use Livewire\Component;

class Navbar extends Component
{
    public $brandName = 'Sarpras';
    public $notificationCount = 5;

    public function render() {
        return view('livewire.components.admin.navbar');
    }
}
