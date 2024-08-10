<?php

namespace App\Livewire\Layouts\InItems;

use App\Models\IncomingItemDetail;
use Livewire\Component;

class Show extends Component
{
    public $items;
    public $incomingItemID;

    public function mount($incomingItemID)
    {
        $this->incomingItemID = $incomingItemID;
        $this->items = IncomingItemDetail::where('incoming_item_code', $this->incomingItemID)->get();
    }
    public function render()
    {
        return view('livewire.layouts.in-items.show');
    }
}
