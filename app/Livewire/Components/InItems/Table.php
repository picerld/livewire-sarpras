<?php

namespace App\Livewire\Components\InItems;

use App\Models\IncomingItem;
use App\Models\IncomingItemDetail;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'users_name', 'label' => 'User', 'class' => 'dark:text-slate-300'],
        ['key' => 'suppliers_name', 'label' => 'Supplier', 'class' => 'dark:text-slate-300'],
        ['key' => 'total_items', 'label' => 'Total Item', 'class' => 'dark:text-slate-300 text-center'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300'],
    ];

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createItems = false;

    //filters
    public $fromDate = null;
    public $toDate = null;
    public $selectedUser = null;

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
            ->when($this->selectedUser, fn (Builder $q) => $q->where('user_id', $this->selectedUser))
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

    public function render()
    {
        $itemsIn = $this->itemsIn();
        $users = User::whereNot('role', 'unit')->get();

        return view('livewire.components.in-items.table', [
            'itemsIn' => $itemsIn,
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'users' => $users
        ]);
    }
}
