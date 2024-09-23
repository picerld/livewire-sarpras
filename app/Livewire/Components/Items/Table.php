<?php

namespace App\Livewire\Components\Items;

use App\Helpers\GenerateCodeHelper;
use App\Helpers\ImageHelper;
use App\Models\Category;
use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;
use Livewire\WithFileUploads;

class Table extends Component
{
    use WithPagination, Toast, WithFileUploads;

    #[Validate]
    public $newItem = [
        'id' => '',
        'name' => '',
        'merk' => '',
        'unit' => '',
        'color' => '',
        'type' => '',
        'size' => '',
        'price' => '',
        'stock' => '',
        'minimum_stock' => '',
        'category_id' => '',
        'description' => '',
        'images' => '',
    ];

    // Table headers
    public $headers = [
        ['key' => 'id', 'label' => 'Kode', 'class' => 'dark:text-slate-300'],
        ['key' => 'name', 'label' => 'Nama', 'class' => 'dark:text-slate-300',],
        ['key' => 'type', 'label' => 'Type', 'class' => 'dark:text-slate-300'],
        ['key' => 'merk', 'label' => 'Merk', 'class' => 'dark:text-slate-300'],
        ['key' => 'category_aliases', 'label' => 'Kategori', 'class' => 'dark:text-slate-300'],
        ['key' => 'stock', 'label' => 'Stok', 'class' => 'dark:text-slate-300'],
        ['key' => 'minimum_stock', 'label' => 'Stok Min', 'class' => 'dark:text-slate-300 text-center'],
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

    // Validation
    public function rules()
    {
        return [
            'newItem.id' => 'required|max:50|min:1',
            'newItem.name' => 'required|string|max:255|min:2',
            'newItem.merk' => 'required|string|max:255|min:2',
            'newItem.color' => 'required|string|max:255|min:2',
            'newItem.type' => 'string|max:255|min:1',
            'newItem.size' => 'string|max:255|min:1',
            'newItem.unit' => 'required|string|max:50|min:2',
            'newItem.price' => 'required|numeric|min:0',
            'newItem.stock' => 'required|integer|min:1',
            'newItem.minimum_stock' => 'required|integer|min:1',
            'newItem.category_id' => 'required|exists:category,id',
            'newItem.description' => 'required|string|max:300|min:10',
            'newItem.images' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'newItem.name.required' => 'nama harus diisi',
            'newItem.merk.required' => 'merk harus diisi',
            'newItem.color.required' => 'warna harus diisi',
            'newItem.size.required' => 'size harus diisi',
            'newItem.unit.required' => 'unit harus diisi',
            'newItem.price.required' => 'harga harus diisi',
            'newItem.stock.required' => 'stok harus diisi',
            'newItem.minimum_stock.required' => 'stok min harus diisi',
            'newItem.category_id.required' => 'kategori harus diisi',
            'newItem.description.required' => 'deskripsi harus diisi',
            'newItem.description.min' => 'deskripsi minimal 10 karakter',
        ];
    }

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
            ->withAggregate('category', 'aliases')
            ->when($this->search, fn(Builder $q) => $q->whereAny(['id', 'name', 'merk', 'price', 'stock'], 'LIKE', "%$this->search%"))
            ->when($this->selectedCategory, fn(Builder $q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5, ['id', 'name', 'price', 'stock', 'minimum_stock', 'category->name', 'created_at']);
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

    public function store(): void
    {
        // try {
        $this->newItem['id'] = GenerateCodeHelper::handleGenerateCode();
        
        $this->validate();
        
        $this->newItem['images'] = ImageHelper::handleImage($this->newItem['images']);

        Item::create([
            'id' => $this->newItem['id'],
            'name' => $this->newItem['name'],
            'unit' => $this->newItem['unit'],
            'merk' => $this->newItem['merk'],
            'color' => $this->newItem['color'],
            'type' => $this->newItem['type'],
            'size' => $this->newItem['size'],
            'price' => $this->newItem['price'],
            'stock' => $this->newItem['stock'],
            'minimum_stock' => $this->newItem['minimum_stock'],
            'category_id' => $this->newItem['category_id'],
            'description' => $this->newItem['description'],
            'images' => $this->newItem['images'],
        ]);

        $this->success("Item created!", 'Success!', position: 'toast-bottom');
        // } catch (\Throwable $th) {
        //     $this->warning($th->getMessage(), 'Warning!!', position: 'toast-bottom');
        // }

        $this->reset('newItem');
        $this->createItems = false;
    }


    public function render()
    {
        $items = $this->items();
        $categories = Category::all();

        $units = [
            [
                'id' => 'Pcs',
                'name' => 'Pcs'
            ],
            [
                'id' => 'Box',
                'name' => 'Box'
            ],
            [
                'id' => 'Rim',
                'name' => 'Rim'
            ],
        ];

        return view('livewire.components.items.table', [
            'items' => $items,
            'categories' => $categories,
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'units' => $units
        ]);
    }
}