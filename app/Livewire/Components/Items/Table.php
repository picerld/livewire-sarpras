<?php

namespace App\Livewire\Components\Items;

use App\Helpers\ImageHelper;
use App\Models\Category;
use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Mary\Traits\Toast;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Table extends Component
{
    use WithPagination, Toast, WithFileUploads;

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
        'description' => '',
        'images' => ''
    ];

    // Table headers
    public $headers = [
        ['key' => 'code', 'label' => 'Kode', 'class' => 'dark:text-slate-300'],
        ['key' => 'name', 'label' => 'Nama', 'class' => 'dark:text-slate-300',],
        ['key' => 'merk', 'label' => 'Merek', 'class' => 'dark:text-slate-300'],
        ['key' => 'price', 'label' => 'Harga', 'class' => 'dark:text-slate-300'],
        ['key' => 'stock', 'label' => 'Stok', 'class' => 'dark:text-slate-300'],
        ['key' => 'minimum_stock', 'label' => 'Stok Min', 'class' => 'dark:text-slate-300 text-center'],
        ['key' => 'category_name', 'label' => 'Kategori', 'class' => 'dark:text-slate-300'],
        ['key' => 'description', 'label' => 'Deskripsi', 'class' => 'dark:text-slate-300'],
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
            ->paginate(5, ['code', 'name', 'merk', 'price', 'stock', 'minimum_stock', 'category->name', 'created_at']);
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
    // func for generate value of random code
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
                    'name' => 'required|string|max:50|min:5',
                    'code' => 'required|string|max:10|unique:items,code|min:5',
                    'unit' => 'required|string|max:20|min:2',
                    'merk' => 'required|string|max:20|min:5',
                    'price' => 'required|numeric',
                    'stock' => 'required|integer|max:999',
                    'minimum_stock' => 'required|integer|max:999',
                    'category_id' => 'required|exists:category,id',
                    'description' => 'required|string|max:100',
                    'images' => 'nullable|image|max:1024'
                ]
            );

            if($validator->fails()) {
                $this->warning($validator->errors()->first(), 'Warning!!', position: 'toast-bottom');
                $this->createItems = false;
                return;
            }
    
            $data = $validator->validated();
            $data['images'] = ImageHelper::handleImage($this->newItem['images']);
    
            Item::create($data);
            $this->success("Item created!", 'Success!', position: 'toast-bottom');
        } catch (\Throwable $th) {            
            $this->warning($th->getMessage(), 'Warning!!', position: 'toast-bottom');
        }

        $this->reset('newItem');
        $this->createItems = false;
    }


    public function render()
    {
        $items = $this->items();
        $categories = Category::all();

        return view('livewire.components.items.table', [
            'items' => $items,
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'categories' => $categories,
        ]);
    }
}
