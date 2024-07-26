<?php

namespace App\Livewire\Components\Items;

use App\Models\Category;
use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Mary\Traits\Toast;
use Illuminate\Support\Str;
use Livewire\Attributes\Lazy;

class Table extends Component
{
    use WithPagination, Toast;

    // create item
    public $newItem = [
        'name' => '',
        'code' => '',
        'unit' => '',
        'merk' => '',
        'price' => '',
        'stock' => '',
        'minimum_stock' => '',
        'category_id' => '',
    ];

    public $headers = [
        ['key' => 'code', 'label' => 'Kode', 'class' => 'dark:text-slate-300'],
        ['key' => 'name', 'label' => 'Nama', 'class' => 'dark:text-slate-300',],
        ['key' => 'merk', 'label' => 'Merek', 'class' => 'dark:text-slate-300'],
        ['key' => 'price', 'label' => 'Harga', 'class' => 'dark:text-slate-300'],
        ['key' => 'stock', 'label' => 'Stok', 'class' => 'dark:text-slate-300'],
        ['key' => 'category_name', 'label' => 'Kategori', 'class' => 'dark:text-slate-300'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300'],
    ];

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createItems = false;

    // filters
    public $selectedCategory = null;
    public $fromDate = null;
    public $toDate = null;

    public function tableDrawer()
    {
        $this->drawerIsOpen = true;
    }

    public function createItemsModal()
    {
        $this->createItems = true;
    }

    public function items(): LengthAwarePaginator
    {
        return Item::query()
            ->withAggregate('category', 'name')
            ->when($this->search, fn (Builder $q) => $q->whereAny(['code', 'name', 'merk', 'price', 'stock'], 'LIKE', "%$this->search%"))
            ->when($this->selectedCategory, fn (Builder $q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->fromDate, fn (Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn (Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5);
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

    // CRUD
    protected function generateCode()
    {
        return substr(hash('sha256', STR::random(40) . time()), 0, 10);
    }

    public function store(): void
    {
        try {
            $this->newItem['code'] = $this->generateCode();
            $validator = Validator::make(
                $this->newItem,
                [
                    'name' => 'required|string|max:50',
                    'code' => 'required|string|max:10|unique:items,code',
                    'unit' => 'required|string|max:20',
                    'merk' => 'required|string|max:20',
                    'price' => 'required|numeric',
                    'stock' => 'required|integer|max:999',
                    'minimum_stock' => 'required|integer|max:999',
                    'category_id' => 'required|exists:category,id',
                ],
            );
            $this->success("Item created!", 'Success!', position: 'toast-bottom');
            Item::create($validator->validated());
        } catch (\Throwable $e) {
            $this->warning($validator->errors()->first(), 'Warning!!', position: 'toast-bottom');
        }
        $this->reset('newItem');
        $this->createItems = false;
    }

    public function delete(Item $item): void
    {
        $item->delete();
        $this->success("Item $item->name deleted", 'Good bye!', position: 'toast-bottom');
    }

    public function render()
    {
        $items = $this->items();
        // dd($items);
        $categories = Category::all();

        return view('livewire.components.items.table', [
            'items' => $items,
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'categories' => $categories,
        ]);
    }
}
