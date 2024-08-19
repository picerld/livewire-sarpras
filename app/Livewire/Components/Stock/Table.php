<?php

namespace App\Livewire\Components\Stock;

use App\Models\IncomingItem;
use App\Models\IncomingItemDetail;
use App\Models\Item;
use App\Models\OutgoingItemDetail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'id', 'label' => 'Kode', 'class' => 'dark:text-slate-300'],
        ['key' => 'name', 'label' => 'Nama', 'class' => 'dark:text-slate-300'],
        ['key' => 'stock', 'label' => 'Stok', 'class' => 'dark:text-slate-300'],
        ['key' => 'stok_barang_masuk', 'label' => 'Stok Masuk', 'class' => 'dark:text-slate-300'],
        ['key' => 'stok_barang_keluar', 'label' => 'Stok Keluar', 'class' => 'dark:text-slate-300'],
    ];

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    public $incoming_stock;
    public $outgoing_stock;

    public Item $item;

    public function mount(Item $item)
    {
        $items = Item::all();
        $this->item = $item;
        // $this->incoming_stock = IncomingItem::withCount('incomingItemDetail:qty')->get();
            

        // dd($this->incoming_stock);
    }

    public function stock(): LengthAwarePaginator
    {
        return Item::query()
            ->when($this->search, fn(Builder $q) => $q->whereAny(['id', 'name', 'merk', 'price', 'stock'], 'LIKE', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5, ['id', 'name', 'stock']);
    }

    public function render()
    {
        return view('livewire.components.stock.table', [
            'stock' => $this->stock(),
            'incoming_stock' => $this->incoming_stock
        ]);
    }
}
