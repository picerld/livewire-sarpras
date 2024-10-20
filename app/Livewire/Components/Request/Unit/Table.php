<?php

namespace App\Livewire\Components\Request\Unit;

use App\Models\Request;
use App\Models\RequestDetail;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'id', 'label' => 'Kode', 'class' => 'dark:text-slate-300'],
        ['key' => 'status', 'label' => 'Status', 'class' => 'dark:text-slate-300'],
        ['key' => 'characteristic', 'label' => 'Sifat', 'class' => 'dark:text-slate-300'],
        ['key' => 'total_items', 'label' => 'Total Item', 'class' => 'dark:text-slate-300'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300'],
    ];

    public int $perPage = 5;

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    public bool $drawerIsOpen = false;
    public bool $createRequest = false;

    public $item;
    public bool $detailRequest = false;

    public $selectedStatus = null;
    public $fromDate = null;
    public $toDate = null;

    public function tableDrawer()
    {
        $this->drawerIsOpen = true;
    }

    public function createRequestModal()
    {
        $this->createRequest = true;
    }

    public function detailRequestModal($requestCode)
    {
        $this->detailRequest = true;
        $this->item = RequestDetail::withAggregate('request', 'regarding')->where('request_code', $requestCode)->get();
    }

    public function requests(): LengthAwarePaginator
    {
        return Request::query()
            ->where('nip', Auth::user()->nip)
            ->withAggregate('users', 'name')
            ->when($this->search, function (Builder $query) {
                $query->whereHas('users', function (Builder $query) {
                    $query->where('name', 'LIKE', "%$this->search%");
                })
                    ->orWhere('id', 'LIKE', "%$this->search%")
                    ->orWhere('total_items', 'LIKE', "%$this->search%")
                    ->orWhere('status', 'LIKE', "%$this->search%")
                    ->orWhere('characteristic', 'LIKE', "%$this->search%");
            })
            ->when($this->selectedStatus, fn(Builder $q) => $q->where('status', $this->selectedStatus))
            ->when($this->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->orderBy('status', 'ASC')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['id', 'total_items', 'status', 'charasterictic'])->withQueryString();
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
        $status = [
            [
                'id' => '1',
                'name' => 'Pending'
            ],
            [
                'id' => '2',
                'name' => 'Accepted'
            ],
            [
                'id' => '3',
                'name' => 'Rejected'
            ],
        ];

        return view('livewire.components.request.unit.table', [
            'headers' => $this->headers,
            'status' => $status,
            'sortBy' => $this->sortBy,
            'requests' => $this->requests()
        ]);
    }
}
