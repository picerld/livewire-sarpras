<?php

namespace App\Livewire\Components\Items;

use App\Helpers\GenerateCodeHelper;
use App\Helpers\ImageHelper;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
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
        'supplier_id' => '',
    ];

    // Table headers
    public $headers = [
        ['key' => 'id', 'label' => 'Kode'],
        ['key' => 'name', 'label' => 'Nama'],
        ['key' => 'supplier_name', 'label' => 'Supplier'],
        ['key' => 'type', 'label' => 'Type'],
        ['key' => 'merk', 'label' => 'Merk'],
        ['key' => 'category_aliases', 'label' => 'Kategori'],
        ['key' => 'stock', 'label' => 'Stok'],
        ['key' => 'minimum_stock', 'label' => 'Stok Min', 'class' => ' text-center'],
    ];

    public int $perPage = 5;

    public $search = "";
    public $sortBy = ['column' => 'name', 'direction' => 'ASC'];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createItems = false;

    // filters
    public $selectedCategory = null;
    public $fromStock = null;
    public $toStock = null;

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
            'newItem.supplier_id' => 'required|exists:supplierS,id',
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
            'newItem.supplier_id.required' => 'supplier harus diisi',
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
            ->withAggregate('supplier', 'name')
            ->when($this->search, fn(Builder $q) => $q->whereAny(['id', 'name', 'merk', 'price', 'stock'], 'LIKE', "%$this->search%"))
            ->when($this->selectedCategory, fn(Builder $q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->fromStock, fn(Builder $q) => $q->where('stock', '>=', $this->fromStock))
            ->when($this->toStock, fn(Builder $q) => $q->where('stock', '<=', $this->toStock))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['id', 'name', 'price', 'stock', 'minimum_stock', 'category->name']);
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
            'supplier_id' => $this->newItem['supplier_id'],
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
        $suppliers = Supplier::all();

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
            'suppliers' => $suppliers,
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'units' => $units
        ]);
    }
}
