<?php

namespace App\Livewire\Components\Report;

use App\Models\Item;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;

    public int $perPage = 6;

    public $headers = [
        ['key' => 'no', 'label' => 'No'],
        ['key' => 'id', 'label' => 'Kode'],
        ['key' => 'name', 'label' => 'Barang'],
        ['key' => 'stock', 'label' => 'Stok'],
        ['key' => 'category_aliases', 'label' => 'Kategori'],
    ];

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    public function items(): LengthAwarePaginator
    {
        return Item::query()
            ->withAggregate('category', 'aliases')
            ->withAggregate('supplier', 'name')
            ->when($this->search, fn(Builder $q) => $q->whereAny(['id', 'name', 'merk', 'price', 'stock'], 'LIKE', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['id', 'name', 'stock', 'category.name']);
    }

    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function render()
    {
        $items = $this->items();

        return view('livewire.components.report.items', [
            'items' => $items,
            'sortBy' => $this->sortBy,
            'headers' => $this->headers,
        ]);
    }
}
