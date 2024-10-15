<?php

namespace App\Livewire\Components\Unit;

use App\Helpers\GenerateCodeHelper;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class ListItem extends Component
{
    use Toast;

    public $newCart = [
        'qty' => null,
    ];

    public $items;
    public $detailItem;

    public $itemDetail;
    public $itemCode;

    public $cartModal;

    public function detailItemModal($itemCode)
    {
        $this->detailItem = true;

        $this->itemCode = $itemCode;
        $this->itemDetail = Item::where('id', $itemCode)->first();
    }

    public function createCartModal($itemCode)
    {
        $this->cartModal = true;

        $this->itemCode = $itemCode;
        $this->itemDetail = Item::where('id', $itemCode)->first();
    }

    public function cart($itemCode)
    {
        $this->newCart['item_code'] = $itemCode;

        $carts = Cart::where('nip', Auth::id())->where('item_code', $itemCode)->first();

        $this->validate([
            'newCart.qty' => 'required|integer|min:1',
        ]);

        if ($carts) {
            $carts->update([
                'qty' => $carts->qty + $this->newCart['qty'],
            ]);
            $this->success("Cart successfully created!", 'Success!', position: 'toast-bottom');
            $this->cartModal = false;
            $this->newCart['qty'] = null;
            return;
        }

        Cart::create([
            'id' => GenerateCodeHelper::handleGenerateCode(),
            'nip' => Auth::user()->nip,
            'item_code' => $this->newCart['item_code'],
            'qty' => $this->newCart['qty'],
        ]);

        $this->success("Cart successfully created!", 'Success!', position: 'toast-bottom');
        $this->newCart['qty'] = null;
        $this->cartModal = false;
    }

    public function mount()
    {
        $this->items = Item::query()
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function render()
    {
        return view('livewire.components.unit.list-item');
    }
}
