<?php

namespace App\Livewire\Components\InItems;

use App\Models\IncomingItem;
use App\Models\IncomingItemDetail;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class FormItemIn extends Component
{
    use Toast;

    // Default value for inputs
    public $inputs = [['item_id' => '', 'qty' => 1]];
    public $items = [];
    public $supplier_id;
    public $i = 1;


    public function mount()
    {
        $this->inputs = [['item_id' => '', 'qty' => 1]];
        $this->items = Item::all();
    }

    public function addInput()
    {
        $this->inputs[] = ['item_id' => '', 'qty' => 1];
    }

    public function removeInput($i)
    {
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
    }

    public function store()
    {
        try {
            // Validate input data
            $this->validate([
                'supplier_id' => 'required|exists:suppliers,id',
                'inputs.*.item_id' => 'required|exists:items,id',
                'inputs.*.qty' => 'required|integer|min:1',
            ]);

            // Store to incoming_item table
            $incomingItem = IncomingItem::create([
                'user_id' => Auth::id(),
                'supplier_id' => $this->supplier_id,
                'total_items' => 0,
                'total_items' => 0, // Default value
            ]);

            // Store to incoming_item_detail table from data incoming_item table
            foreach ($this->inputs as $input) {
                IncomingItemDetail::create([
                    'incoming_item_id' => $incomingItem->id,
                    'item_id' => $input['item_id'],
                    'qty' => $input['qty'],
                ]);
            }

            $incomingItem->update([
                'total_items' => $incomingItem->incomingItemDetail->sum('qty'),
            ]);

            // Update total_items in incoming_item table
            $totalItems = IncomingItemDetail::where('incoming_item_id', $incomingItem->id)
                ->sum('qty');

            $incomingItem->update(['total_items' => $totalItems]);

            $this->success("Item Successfully Added", "Success!!", position: 'toast-bottom');
            $this->reset(['inputs', 'supplier_id', 'item_id', 'qty']);
            
        } catch (\Throwable $th) {
            $this->warning($th->getMessage(), 'Warning!!', position: 'toast-bottom');
        }
    }

    public function render()
    {
        $suppliers = Supplier::all();
        $items = Item::all();

        return view('livewire.components.in-items.form-item-in', [
            'suppliers' => $suppliers,
            'items' => $items,
            "suppliers" => $suppliers
        ]);
    }
}