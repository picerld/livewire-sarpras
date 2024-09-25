<?php

namespace App\Livewire\Components\OutItems;

use App\Models\Item;
use App\Models\OutgoingItem;
use App\Models\OutgoingItemDetail;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'users_name', 'label' => 'Unit', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'item_name', 'label' => 'Barang', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'total_items', 'label' => 'Kuantiti', 'class' => 'dark:text-slate-300 text-center text-sm'],
        ['key' => 'status', 'label' => 'Status', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'updated_at', 'label' => 'Tanggal Diambil', 'class' => 'dark:text-slate-300 text-sm'],
    ];

    public int $perPage = 5;

    // search
    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    // drawer
    public bool $drawerIsOpen = false;

    // filters
    public $fromDate = null;
    public $toDate = null;
    public $selectedUser = null;

    public function tableDrawer()
    {
        $this->drawerIsOpen = true;
    }

    public function itemsOut(): LengthAwarePaginator
    {
        return OutgoingItem::query()
            ->withAggregate('users', 'name')
            ->withAggregate('item', 'name')
            ->when($this->search, function (Builder $query) {
                $query->whereHas('users', function (Builder $query) {
                    $query->where('name', 'LIKE', "%$this->search%");
                })
                    ->orWhere('status', 'LIKE', "%$this->search%")
                    ->orWhere('total_items', 'LIKE', "%$this->search%");
            })
            ->when($this->selectedUser, fn(Builder $q) => $q->where('nip', $this->selectedUser))
            ->when($this->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['users_name', 'status', 'total_items', 'created_at']);
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

    public function delete(OutgoingItem $outgoingItem): void
    {
        $outgoingItem->delete();
        $this->success("Report for  id #$outgoingItem->id deleted", 'Good bye!', position: 'toast-bottom');
    }

    public function render()
    {
        $itemsOut = $this->itemsOut();

        $users = User::withAggregate('employee', 'name')->get();
        $userMap = $users->map(function (User $user) {
            return [
                'id' => $user->nip,
                'name' => $user->employee->name
            ];
        });

        return view('livewire.components.out-items.table', [
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'itemsOut' => $itemsOut,
            'users' => $userMap,
        ]);
    }
}
