<?php

namespace App\Livewire\Layouts\Report;

use Livewire\Component;

class Show extends Component
{
    public $itemId;

    public function mount($itemId)
    {
        $this->itemId = $itemId;
    }

    public function render()
    {
        return view('livewire.layouts.report.show');
    }
}
