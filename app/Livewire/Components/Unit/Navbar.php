<?php

namespace App\Livewire\Components\Unit;

use Livewire\Component;

class Navbar extends Component
{
    public $brandName = 'Sarpras';
    public function render()
    {
        return view('livewire.components.unit.navbar');
    }
}
