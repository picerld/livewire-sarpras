<?php

namespace App\Livewire\Components\InItems;

use App\Helpers\GenerateCodeHelper;
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

    public Item $item;

    // Default value for inputs
    // it will be
    // [0 => ['item_id' => '', 'qty' => 1], 
    // 1 => ['item_id' => '', 'qty' => 1]] ...
    public $inputs = [['item_code' => '', 'qty' => 1]];
    public $items;
    public $supplier_id;

    // Index for loop input
    public $i = 1;

    // search
    public $search;

    public function mount()
    {
        $this->items = Item::all();
    }

    public function addInput()
    {
        // Add new input field on object
        $this->inputs[] = ['item_code' => '', 'qty' => 1];
    }

    public function removeInput($i)
    {
        // Remove input field on object based on index
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
    }

    public function store()
    {
        // try {
            // Validate input data
            $this->validate([
                'supplier_id' => 'required|exists:suppliers,id',
                'inputs.*.item_code' => 'required|exists:items,id',
                'inputs.*.qty' => 'required|integer|min:1',
            ], [
                'supplier_id.required' => 'Supplier harus dipilih',
                'inputs.*.item_code.required' => 'Item harus dipilih',
                'inputs.*.qty.required' => 'Jumlah harus diisi',
                'inputs.*.qty.min' => 'Jumlah minimal 1',
            ]);

            // Store to incoming_item table
            $incomingItem = IncomingItem::create([
                'id' => GenerateCodeHelper::handleGenerateCode(),
                'nip' => Auth::id(),
                'supplier_id' => $this->supplier_id,
                'total_items' => 0, // Default value
            ]);

            // Initialize total items counter
            $totalItems = 0;

            // Store to incoming_item_detail table and update item quantities
            foreach ($this->inputs as $input) {
                IncomingItemDetail::create([
                    'incoming_item_code' => $incomingItem->id,
                    'item_code' => $input['item_code'],
                    'qty' => $input['qty'],
                ]);

                $item = Item::find($input['item_code']);
                $item->update(['stock' => $item->stock + $input['qty']]);
                $totalItems += $input['qty'];
            }

            // Update total_items in incoming_item table
            $incomingItem->update([
                'total_items' => $totalItems,
            ]);

            $this->success("Item Successfully Added", "Success!!", position: 'toast-bottom', redirectTo: '/in-items');
            $this->reset(['inputs', 'supplier_id']);
        // } catch (\Throwable $th) {
            // $this->warning('Ada kendala saat proses penginputan', 'Warning!!', position: 'toast-bottom', redirectTo: '/in-items');
            // development purpose
            // $this->warning($th->getMessage(), 'Warning!!', position: 'toast-bottom');
        // }
    }

    public function render()
    {
        $suppliers = Supplier::all();
        $items = Item::all();

        return view('livewire.components.in-items.form-item-in', [
            'suppliers' => $suppliers,
            'items' => $items,
            "suppliers" => $suppliers,
        ]);
    }
}
