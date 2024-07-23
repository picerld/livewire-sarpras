<?php

namespace App\Livewire\Components\Items;

use App\Models\Item;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Table extends Component
{
    use WithPagination;

    public $headers = [
        ['key' => 'kode', 'label' => 'Kode', 'class' => 'dark:text-slate-300'],
        ['key' => 'nama', 'label' => 'Nama', 'class' => 'dark:text-slate-300',],
        ['key' => 'merek', 'label' => 'Merek', 'class' => 'dark:text-slate-300'],
        ['key' => 'harga', 'label' => 'Harga', 'class' => 'dark:text-slate-300'],
        ['key' => 'stok', 'label' => 'Stok', 'class' => 'dark:text-slate-300'],
        ['key' => 'kategori.nama', 'label' => 'Kategori', 'class' => 'dark:text-slate-300'],
    ];

    public $search = "";
    public $sortBy = ['column' => 'kode', 'direction' => 'asc'];

    public bool $drawerIsOpen = false;

    public function tableDrawer() {
        $this->drawerIsOpen = true;
    }

    public function items(): LengthAwarePaginator {
        return Item::query()
            ->withAggregate('kategori', 'nama')
            ->when($this->search, fn(Builder $q) => $q->whereAny(['kode', 'nama', 'merek', 'harga', 'stok'], 'LIKE', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5);
    }

    public function updated($property): void {
        if(! is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function clear(): void {
        $this->reset();
        // $this->resetPage();
        // $this->success('Filters cleared.', position: 'toast-bottom');
    }

    public function delete(Item $item): void {
        $item->delete();
        // $this->warning("$user->nama deleted", 'Good bye!', position: 'toast-bottom');
    }

    public function render() {
        $items = $this->items();
        // dd($items);

        return view('livewire.components.items.table', [
            'items' => $items,
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
        ]);
    }

    public function with(): array {
        return [
            "items" => $this->items(),
            "headers" => $this->headers(),
        ];
    }
}
