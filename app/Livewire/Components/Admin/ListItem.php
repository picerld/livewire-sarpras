<?php

namespace App\Livewire\Components\Admin;

use App\Models\Item;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListItem extends Component
{
    use WithPagination, Toast;

    // search
    public $search = "";
    public $sortBy = ['column' => 'stock', 'direction' => 'ASC'];

    public function items(): LengthAwarePaginator
    {
        return Item::query()
            ->withAggregate('category', 'aliases')
            ->when($this->search, function (Builder $q) {
                $q->whereHas('category', function (Builder $q) {
                    $q->where('aliases', 'LIKE', "%$this->search%");
                })
                    ->orWhereAny(['id', 'name', 'merk', 'price', 'stock'], 'LIKE', "%$this->search%");
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5);
    }

    public function clear(): void
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.components.admin.list-item', [
            'items' => $this->items(),
        ]);
    }
}
