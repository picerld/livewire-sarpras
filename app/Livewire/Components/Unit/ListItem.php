<?php

namespace App\Livewire\Components\Unit;

use App\Helpers\GenerateCodeHelper;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListItem extends Component
{
    use Toast, WithPagination;

    public $newCart = [
        'item_code' => '',
        'qty' => null,
    ];

    public int $perPage = 8;

    public int $maxItems;

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

    public function loadItems($context)
    {
        if ($context === "more") {
            $this->perPage = min($this->perPage + 4, $this->maxItems);
        } elseif ($context === "less") {
            $this->perPage = max($this->perPage - 4, 4);
        }

        $this->resetPage();
        $this->items = $this->items()->items();

        return $this->items;
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
        $this->defaultItems = $this->items()->items();
        $this->items = $this->items()->items();

        $this->maxItems = Item::count();
    }

    public function items(): LengthAwarePaginator
    {
        return Item::leftJoin('request_detail', 'items.id', '=', 'request_detail.item_code')
            ->select('items.*', DB::raw('COUNT(request_detail.id) as request_count'))
            ->groupBy('items.id')
            ->orderBy('request_count', 'DESC')
            ->orderBy('items.name', 'ASC')
            ->paginate($this->perPage)
            ->withQueryString();
    }

    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function clear(): void
    {
        $this->reset();
        $this->resetPage();
        $this->success('Filters cleared.', position: 'toast-bottom');
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
            'items' => $this->items,
            'maxItems' => $this->maxItems
        ]);
    }
}
