<?php

namespace App\Livewire\Layouts\Items;

use App\Models\Item;
use Livewire\Component;

class Show extends Component
{
    public $item;
    public $itemCode;

    public function mount($itemCode)
    {
        $this->itemCode = $itemCode;
        $this->item = Item::findOrFail($this->itemCode);
    }

    public function render()
    {
        return view('livewire.layouts.items.show');
    }
}
