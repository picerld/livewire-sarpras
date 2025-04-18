<?php

namespace App\Livewire\Components\Request;

use App\Models\Request;
use App\Models\RequestDetail;
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
        ['key' => 'id', 'label' => 'Kode', 'class' => 'dark:text-slate-300'],
        ['key' => 'users_name', 'label' => 'User', 'class' => 'dark:text-slate-300'],
        ['key' => 'status', 'label' => 'Status', 'class' => 'dark:text-slate-300'],
        ['key' => 'characteristic', 'label' => 'Sifat', 'class' => 'dark:text-slate-300'],
        ['key' => 'total_items', 'label' => 'Total Item', 'class' => 'dark:text-slate-300'],
        ['key' => 'regarding', 'label' => 'Perihal', 'class' => 'dark:text-slate-300'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300'],
    ];

    public int $perPage = 5;

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    public bool $drawerIsOpen = false;
    public bool $createRequest = false;
    public bool $requestExportPdf = false;

    // filter
    public $selectedUser = null;
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

    public function requestPdfModal()
    {
        $this->requestExportPdf = true;
    }

    public function requests(): LengthAwarePaginator
    {
        return Request::query()
            ->withAggregate('users', 'name')
            ->when($this->search, function (Builder $query) {
                $query->whereHas('users', function (Builder $query) {
                    $query->where('name', 'LIKE', "%$this->search%");
                })
                    ->orWhere('id', 'LIKE', "%$this->search%");
            })
            ->when($this->selectedStatus, fn(Builder $q) => $q->where('status', $this->selectedStatus))
            ->when($this->selectedUser, fn(Builder $q) => $q->where('nip', $this->selectedUser))
            ->when($this->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->orderBy('status', 'ASC')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['id', 'users_name', 'total_items', 'status', 'regarding', 'charasterictic']);
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

    public function delete(Request $request, RequestDetail $requestDetail): void
    {
        $request->delete();
        $requestDetail->delete();
        $this->success("Submission with code #$request->id successfully deleted!!", 'Good bye!', position: 'toast-bottom');
    }

    public function render()
    {
        $users = User::withAggregate('employee', 'name')->get();
        // mapping users
        $userMap = $users->map(function (User $user) {
            return [
                'id' => $user->nip,
                'name' => $user->employee->name
            ];
        });

        $userNameExplode = $users->map(function (User $user) {
            return [
                'id' => $user->nip,
                'name' => strtoupper(trim(explode('@', $user->username)[0])),
            ];
        });

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

        return view('livewire.components.request.table', [
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'users' => $userMap,
            'userNameExplode' => $userNameExplode,
            'status' => $status,
            'requests' => $this->requests()
        ]);
    }
}
