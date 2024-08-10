<?php

namespace App\Livewire\Layouts\Items;

use App\Models\Item;
use Livewire\Component;

class Show extends Component
{
    public $item;
    public $itemId;

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->item = Item::findOrFail($this->itemId);
    }

    public function render()
    {
        return view('livewire.layouts.items.show');
    }
}
