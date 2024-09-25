<?php

namespace App\Livewire\Components\InItems;

use App\Models\IncomingItem;
use App\Models\IncomingItemDetail;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    // header table
    public $headers = [
        ['key' => 'users_name', 'label' => 'Petugas', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'suppliers_name', 'label' => 'Supplier', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'total_items', 'label' => 'Total Item', 'class' => 'dark:text-slate-300 text-center text-sm'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300 text-sm'],
    ];

    public int $perPage = 5;

    // search
    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createItems = false;

    // filters
    public $fromDate = null;
    public $toDate = null;
    public $selectedUser = null;
    public $selectedSupplier = null;

    public function tableDrawer()
    {
        $this->drawerIsOpen = true;
    }

    public function createItemsModal()
    {
        $this->createItems = true;
    }

    public function itemsIn(): LengthAwarePaginator
    {
        return IncomingItem::query()
            ->withAggregate('users', 'name')
            ->withAggregate('suppliers', 'name')
            ->when($this->search, function (Builder $query) {
                $query->whereHas('users', function (Builder $query) {
                    $query->where('name', 'LIKE', "%$this->search%");
                })
                    ->orWhere('supplier_id', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('total_items', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->selectedSupplier, fn(Builder $q) => $q->where('supplier_id', $this->selectedSupplier))
            ->when($this->selectedUser, fn(Builder $q) => $q->where('nip', $this->selectedUser))
            ->when($this->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['users_name', 'suppliers_name', 'total_items', 'created_at']);
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

    public function delete(IncomingItem $incomingItem, IncomingItemDetail $incomingItemDetail): void
    {
        $items = Item::whereIn('id', $incomingItemDetail->pluck('item_code'))->get();

        foreach ($items as $item) {
            $item->update(['stock' => $item->stock - $incomingItemDetail->where('incoming_item_code', $incomingItem->id)
                ->where('item_code', $item->id)->sum('qty')]);
        }

        $incomingItemDetail->delete();
        $incomingItem->delete();
        $this->success("Item $incomingItem->name deleted", 'Good bye!', position: 'toast-bottom');
    }

    public function render()
    {
        $itemsIn = $this->itemsIn();
        $suppliers = Supplier::all();

        // manualy option role
        $users = [
            [
                'id' => '111',
                'name' => 'Admin'
            ],
            [
                'id' => '222',
                'name' => 'Pengawas'
            ],
        ];

        return view('livewire.components.in-items.table', [
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'itemsIn' => $itemsIn,
            'users' => $users,
            'suppliers' => $suppliers
        ]);
    }
}
