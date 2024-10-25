<?php

namespace App\Livewire\Components\Unit;

use App\Helpers\GenerateCodeHelper;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
    public string $search = '';
    public array $selectedCategory = [];

    // Modals
    public $detailItem = false;
    public $cartModal = false;
    public $itemDetail;
    public $itemCode;

    protected $updatesQueryString = ['search'];
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'newCart.qty' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->maxItems = Item::count();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function items(): LengthAwarePaginator
    {
        return Item::query()
            ->leftJoin('request_detail', 'items.id', '=', 'request_detail.item_code')
            ->select('items.*', DB::raw('COUNT(request_detail.id) as request_count'))
            ->when($this->search, function (Builder $query) {
                $searchTerm = '%' . addcslashes($this->search, '%_') . '%';
                $query->where(function (Builder $q) use ($searchTerm) {
                    $q->where('items.id', 'LIKE', $searchTerm)
                        ->orWhere('items.name', 'LIKE', $searchTerm)
                        ->orWhere('items.merk', 'LIKE', $searchTerm)
                        ->orWhere('items.price', 'LIKE', $searchTerm)
                        ->orWhere('items.stock', 'LIKE', $searchTerm);
                });
            })
            ->when(!empty(array_filter($this->selectedCategory)), function (Builder $query) {
                $query->whereIn('category_id', array_keys(array_filter($this->selectedCategory)));
            })
            ->groupBy('items.id')
            ->orderBy('request_count', 'DESC')
            ->orderBy('items.name', 'ASC')
            ->paginate($this->perPage);
    }

    public function loadItems($context)
    {
        $this->perPage = match ($context) {
            'more' => min($this->perPage + 4, $this->maxItems),
            'less' => max($this->perPage - 4, 4),
            default => $this->perPage,
        };

        $this->resetPage();
    }

    public function detailItemModal($itemCode)
    {
        $this->itemCode = $itemCode;
        $this->itemDetail = Item::findOrFail($itemCode);
        $this->detailItem = true;
    }

    public function createCartModal($itemCode)
    {
        $this->itemCode = $itemCode;
        $this->itemDetail = Item::findOrFail($itemCode);
        $this->cartModal = true;
    }

    public function cart($itemCode)
    {
        try {
            $this->newCart['item_code'] = $itemCode;
            $this->validate();

            DB::transaction(function () use ($itemCode) {
                $cart = Cart::firstOrNew([
                    'nip' => Auth::user()->nip,
                    'item_code' => $itemCode,
                ]);

                if ($cart->exists) {
                    $cart->increment('qty', $this->newCart['qty']);
                } else {
                    $cart->fill([
                        'id' => GenerateCodeHelper::handleGenerateCode(),
                        'qty' => $this->newCart['qty'],
                    ])->save();
                }
            });

            $this->success('Cart successfully created!', 'Success!', position: 'toast-bottom');
            $this->resetCart();
        } catch (\Throwable $th) {
            $this->error('Try again later ...', 'Something wrong!!', position: 'toast-bottom');
        }
    }

    protected function resetCart(): void
    {
        $this->cartModal = false;
        $this->newCart = ['item_code' => null, 'qty' => null];
    }

    public function clear(): void
    {
        $this->reset(['search', 'selectedCategory']);
        $this->resetPage();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }


    public function render()
    {
        return view('livewire.components.unit.list-item', [
            'categories' => Category::all(),
            'items' => $this->items(),
            'maxItems' => $this->maxItems
        ]);
    }
}
