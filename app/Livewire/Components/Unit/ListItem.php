<?php

namespace App\Livewire\Components\Unit;

use App\Helpers\GenerateCodeHelper;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class ListItem extends Component
{
    use Toast;

    public $newCart = [
        'item_code' => '',
        'qty' => null,
    ];

    public $items;
    public $defaultItems;

    public $detailItem;

    public $itemDetail;
    public $itemCode;

    public $cartModal;

    public $selectedCategory = [];

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
        try {
            $this->newCart['item_code'] = $itemCode;

            $carts = Cart::where('nip', Auth::user()->nip)->where('item_code', $itemCode)->first();

            $this->validate([
                'newCart.qty' => 'required|integer|min:1',
            ]);

            if ($carts) {
                $carts->update([
                    'qty' => $carts->qty + $this->newCart['qty'],
                ]);
                $this->success("Cart successfully created!", 'Success!', position: 'toast-bottom');
                $this->cartModal = false;
                $this->newCart = ['item_code' => null, 'qty' => null];
                return;
            }

            Cart::create([
                'id' => GenerateCodeHelper::handleGenerateCode(),
                'nip' => Auth::user()->nip,
                'item_code' => $this->newCart['item_code'],
                'qty' => $this->newCart['qty'],
            ]);

            $this->success("Cart successfully created!", 'Success!', position: 'toast-bottom');
            $this->newCart = ['item_code' => null, 'qty' => null];
            $this->cartModal = false;
        } catch (\Throwable $th) {
            $this->cartModal = false;
            $this->error('Try again later ...', 'Something wrong!!', position: 'toast-bottom');
        }
    }

    public function mount()
    {
        $this->defaultItems = Item::orderBy('name', 'ASC')->get();
        $this->items = $this->defaultItems;
    }

    public function updatedSelectedCategory()
    {
        $this->applyFilters();
    }

    public function applyFilters()
    {
        $selectedCategoryIds = array_keys(array_filter($this->selectedCategory));

        if (empty($selectedCategoryIds)) {
            $this->items = $this->defaultItems;
        } else {
            $this->items = Item::whereIn('category_id', $selectedCategoryIds)
                ->orderBy('category_id', 'ASC')
                ->get();
        }
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.components.unit.list-item', [
            'categories' => $categories,
            'items' => $this->items
        ]);
    }
}
