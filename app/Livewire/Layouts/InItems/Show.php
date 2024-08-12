<?php

namespace App\Livewire\Layouts\InItems;

use App\Models\IncomingItemDetail;
use Livewire\Component;

class Show extends Component
{
    public $items;
    public $incomingItemCode;

    public function mount($incomingItemCode)
    {
        $this->incomingItemCode = $incomingItemCode;
        $this->items = IncomingItemDetail::where('incoming_item_code', $this->incomingItemCode)->get();
    }
    public function render()
    {
        return view('livewire.layouts.in-items.show');
    }
}
