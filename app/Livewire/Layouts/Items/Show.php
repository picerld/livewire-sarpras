<?php

namespace App\Livewire\Layouts\Items;

use App\Models\Item;
use Livewire\Component;

class Show extends Component
{
    public $item;
    public $itemID;

    public function mount($itemID)
    {
        $this->itemID = $itemID;
        $this->item = Item::findOrFail($this->itemID);
    }

    public function render()
    {
        return view('livewire.layouts.items.show');
    }
}
