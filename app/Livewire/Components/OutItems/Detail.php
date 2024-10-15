<?php

namespace App\Livewire\Components\OutItems;

use App\Models\OutgoingItemDetail;
use Livewire\Component;
use Mary\Traits\Toast;

class Detail extends Component
{
    use Toast;

    // params
    public $items;
    public $outgoingItemCode;

    public function mount($outgoingItemCode): void
    {
        $this->outgoingItemCode = $outgoingItemCode;
        $this->items = OutgoingItemDetail::where('outgoing_item_code', $this->outgoingItemCode)->get();
    }

    public function render()
    {
        return view('livewire.components.out-items.detail');
    }
}
