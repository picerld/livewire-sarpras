<?php

namespace App\Livewire\Layouts\OutItems;

use App\Models\OutgoingItemDetail;
use Livewire\Component;

class Show extends Component
{
    public $items;
    public $outgoingItemCode;

    public function mount($outgoingItemCode)
    {
        $this->outgoingItemCode = $outgoingItemCode;
        $this->items = OutgoingItemDetail::where('outgoing_item_code', $this->outgoingItemCode)->get();
    }
    public function render()
    {
        return view('livewire.layouts.out-items.show');
    }
}
