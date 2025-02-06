<?php

namespace App\Livewire\Components\Cart;

use App\Helpers\GenerateCodeHelper;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Submission;
use App\Models\SubmissionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mary\Traits\Toast;

class ListItem extends Component
{
    use Toast;

    public $items;
    public $checkedItems = [];
    public $totalQtyByUnit;

    // store to submission
    public $regarding;

    public function mount()
    {
        $this->items = Cart::where('nip', Auth::user()->nip)->get();

        $this->totalQtyByUnit = $this->items->groupBy(function ($cartItem) {
            return optional(Item::find($cartItem->item_code))->unit;
        })->map(function ($group, $unit) {
            return [
                'unit' => $unit,
                'total' => $group->sum('qty'),
            ];
        });
    }

    public function delete(Cart $cart): void
    {
        $cart->delete();
        $this->success("Item successfully deleted!", 'Success!', redirectTo: route('carts.index'), position: 'toast-bottom');
    }

    public function getCheckedItems(): array
    {
        return array_filter($this->checkedItems, fn($checked) => $checked);
    }

    public function checkAll(): void
    {
        $isAllChecked = !in_array(false, $this->checkedItems);

        if (empty($this->checkedItems)) {
            $this->checkedItems = array_fill_keys(
                $this->items->pluck('item_code')->toArray(),
                true
            );
            return;
        }

        if ($isAllChecked) {
            $this->checkedItems = array_fill_keys(
                $this->items->pluck('item_code')->toArray(),
                false
            );
            return;
        }

        $this->checkedItems = array_fill_keys(
            $this->items->pluck('item_code')->toArray(),
            true
        );
    }

    public function store(): void
    {
        $validator = Validator::make([
            'regarding' => $this->regarding,
        ], [
            'regarding' => 'required|string|min:5|max:200',
        ], [
            'regarding.required' => 'Perihal harus diisi',
            'regarding.min' => 'Perihal minimal 5 karakter',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first(), 'Warning!!', position: 'toast-bottom');
            return;
        }

        $totalItems = 0;

        $checkedItems = $this->getCheckedItems();

        if (empty($checkedItems)) {
            $this->error('Belum ada item yang dipilih!', 'Warning!!', position: 'toast-bottom');
            return;
        }

        $submission = Submission::create([
            'id' => GenerateCodeHelper::handleGenerateCode(),
            'nip' => Auth::user()->nip,
            'status' => 'pending',
            'regarding' => $this->regarding,
            'total_items' => 0,
        ]);

        foreach ($checkedItems as $itemCode => $checked) {
            if ($checked) {
                $item = Item::find($itemCode);
                $cartItem = Cart::where('nip', $submission->nip)->where('item_code', $itemCode)->first();

                SubmissionDetail::create([
                    'id' => GenerateCodeHelper::handleGenerateCode(),
                    'submission_code' => $submission->id,
                    'item_code' => $item->id,
                    'custom_item' => null,
                    'accepted_by' => null,
                    'status_note' => null,
                    'qty' => $cartItem->qty,
                    'qty_accepted' => 0,
                ]);

                $totalItems += $cartItem->qty;

                $cartItem->delete();

                $submission->update([
                    'total_items' => $totalItems,
                ]);
            }
        }

        $this->success('Submission successfully created!', 'Success!', redirectTo: route('carts.index'), position: 'toast-bottom');
    }

    public function decrement($id)
    {
        Cart::where('id', $id)->decrement('qty', 1);
        $this->items = Cart::where('nip', Auth::user()->nip)->get();
        $this->totalQtyByUnit = $this->items->groupBy(function ($cartItem) {
            return optional(Item::find($cartItem->item_code))->unit;
        })->map(function ($group, $unit) {
            return [
                'unit' => $unit,
                'total' => $group->sum('qty'),
            ];
        });
    }

    public function increment($id)
    {
        Cart::where('id', $id)->increment('qty', 1);
        $this->items = Cart::where('nip', Auth::user()->nip)->get();
        $this->totalQtyByUnit = $this->items->groupBy(function ($cartItem) {
            return optional(Item::find($cartItem->item_code))->unit;
        })->map(function ($group, $unit) {
            return [
                'unit' => $unit,
                'total' => $group->sum('qty'),
            ];
        });
    }

    public function render()
    {
        $checkedItems = $this->getCheckedItems();
        $countCheckedItems = count($checkedItems);

        return view('livewire.components.cart.list-item', [
            'countCheckedItems' => $countCheckedItems,
        ]);
    }
}
