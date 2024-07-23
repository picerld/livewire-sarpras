<?php

namespace App\Livewire\Components\Items;

use App\Models\Item;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'code', 'label' => 'Kode', 'class' => 'dark:text-slate-300'],
        ['key' => 'name', 'label' => 'Nama', 'class' => 'dark:text-slate-300',],
        ['key' => 'merk', 'label' => 'Merek', 'class' => 'dark:text-slate-300'],
        ['key' => 'price', 'label' => 'Harga', 'class' => 'dark:text-slate-300'],
        ['key' => 'stock', 'label' => 'Stok', 'class' => 'dark:text-slate-300'],
        ['key' => 'category.name', 'label' => 'Kategori', 'class' => 'dark:text-slate-300'],
    ];

    public $search = "";
    public $sortBy = ['column' => 'code', 'direction' => 'asc'];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $deleteModal = false;

    public function tableDrawer()
    {
        $this->drawerIsOpen = true;
    }

    public function items(): LengthAwarePaginator
    {
        return Item::query()
            ->withAggregate('category', 'name')
            ->when($this->search, fn (Builder $q) => $q->whereAny(['code', 'name', 'merk', 'price', 'stock'], 'LIKE', "%$this->search%"))
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
        // $this->resetPage();
        // $this->success('Filters cleared.', position: 'toast-bottom');
    }

    public function delete(Item $item): void
    {
        $item->delete();
        $this->error("$item->name deleted", 'Good bye!', position: 'toast-bottom');
    }

    public function render()
    {
        $items = $this->items();
        // dd($items);

        return view('livewire.components.items.table', [
            'items' => $items,
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
        ]);
    }

    public function with(): array
    {
        return [
            "items" => $this->items(),
            "headers" => $this->headers(),
        ];
    }
}
