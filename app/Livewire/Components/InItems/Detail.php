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
    public $items;
    public $incomingItemCode;

    public function mount($incomingItemCode): void
    {
        $this->incomingItemCode = $incomingItemCode;
        $this->items = IncomingItemDetail::where('incoming_item_code', $this->incomingItemCode)->get();
    }

    public function save($itemId, $incomingItemCode): void
    {
        $item = Item::find($itemId);

        $totalQty = IncomingItemDetail::where('item_code', $itemId)
            ->where('incoming_item_code', $incomingItemCode)
            ->sum('qty');

        dd(abs($item->stock - $totalQty));


        if ($item) {
            $item->update(['stock' => abs($item->stock - $totalQty)]);

            IncomingItemDetail::where('item_code', $itemId)
                ->where('incoming_item_code', $incomingItemCode)
                ->delete();

            $totalItems = IncomingItemDetail::where('incoming_item_code', $incomingItemCode)
                ->sum('qty');

            IncomingItem::where('id', $incomingItemCode)
                ->update(['total_items' => $totalItems]);
        }

        $this->success("Item $item->name deleted", 'Good bye!', redirectTo: "/in-items/{$this->incomingItemCode}", position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.components.in-items.detail');
    }
}
