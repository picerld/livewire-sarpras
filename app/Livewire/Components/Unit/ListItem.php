<?php

namespace App\Livewire\Components\Unit;

use App\Models\Item;
use Livewire\Component;

class ListItem extends Component
{
    public $items;

    public function mount()
    {
        $this->items = Item::all();
    }
    public function render()
    {
        return view('livewire.components.unit.list-item');
    }
}
