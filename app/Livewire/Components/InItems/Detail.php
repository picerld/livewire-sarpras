<?php

namespace App\Livewire\Components\InItems;

use App\Models\IncomingItem;
use App\Models\IncomingItemDetail;
use App\Models\Item;
use Livewire\Component;
use Mary\Traits\Toast;

class Detail extends Component
{
    use Toast;

    // params
    public $incomingItemID;
    public $items;

    public function mount($incomingItemID): void
    {
        $this->incomingItemID = $incomingItemID;
        $this->items = IncomingItemDetail::where('incoming_item_code', $this->incomingItemID)->get();
    }

    public function delete($itemID, $incomingItemID): void
    {
        // search for qty item on incoming_item_detail
        $totalQty = IncomingItemDetail::where('item_code', $itemID)
            ->where('incoming_item_code', $incomingItemID)
            ->sum('qty');

        // search for item on item table from param
        $item = Item::find($itemID);

        if ($item) {
            // Update item stock on item table
            $item->update(['stock' => $item->stock - $totalQty]);

            IncomingItemDetail::where('item_code', $itemID)
                ->where('incoming_item_code', $incomingItemID)
                ->delete();

            // Update total item on incoming_item
            $totalItems = IncomingItemDetail::where('incoming_item_code', $incomingItemID)
                ->sum('qty');

            IncomingItem::where('id', $incomingItemID)
                ->update(['total_items' => $totalItems]);
        }

        $this->success("Item $item->name deleted", 'Good bye!', redirectTo: "/in-items/{$this->incomingItemID}", position: 'toast-bottom');
    }
    
    public function render()
    {
        return view('livewire.components.in-items.detail');
    }
}
