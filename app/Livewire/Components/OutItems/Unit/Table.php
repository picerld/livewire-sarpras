<?php

namespace App\Livewire\Components\OutItems\Unit;

use App\Models\OutgoingItem;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'id', 'label' => 'Kode', 'class' => 'text-base'],
        ['key' => 'status', 'label' => 'Status', 'class' => 'text-base'],
        ['key' => 'total_items', 'label' => 'Total Item', 'class' => 'text-base'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'text-base'],
    ];

    public int $perPage = 5;

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    public $selectedStatus = null;
    public $fromDate = null;
    public $toDate = null;

    public function itemsOut(): LengthAwarePaginator
    {
        return OutgoingItem::query()
            ->whereAny(['id', 'status', 'total_items'], 'LIKE', "%$this->search%")
            ->when($this->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->when($this->selectedStatus, fn(Builder $q) => $q->where('status', $this->selectedStatus))
            ->orderBy('status', 'DESC')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['id', 'status', 'total_items', 'created_at']);
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
        $itemsOut = $this->itemsOut();

        $status = [
            [
                'id' => 0,
                'name' => 'not taken'
            ],
            [
                'id' => 1,
                'name' => 'taken'
            ],
        ];

        return view('livewire.components.out-items.unit.table', [
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'itemsOut' => $itemsOut,
            'status' => $status,
        ]);
    }
}
