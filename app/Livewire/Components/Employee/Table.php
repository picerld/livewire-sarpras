<?php

namespace App\Livewire\Components\Employee;

use App\Models\Employee;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'id', 'label' => 'NIP', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'name', 'label' => 'Nama', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300 text-sm'],
    ];

    public $newEmployee = [
        'id' => '',
        'name' => '',
    ];

    public int $perPage = 5;

    // search
    public $search = "";
    public $sortBy = ['column' => 'name', 'direction' => 'ASC'];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createEmployees = false;

    // filters
    public $fromDate = null;
    public $toDate = null;

    public function tableDrawer()
    {
        $this->drawerIsOpen = true;
    }

    public function createEmployeesModal()
    {
        $this->createEmployees = true;
    }

    public function employees(): LengthAwarePaginator
    {
        return Employee::query()
            ->when($this->search, fn(Builder $query) => $query->whereAny(['name', 'nip', 'created_at'], 'like', '%' . $this->search . '%'))
            ->when($this->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['id', 'name', 'created_at']);
    }

    public function store(): void
    {
        $this->validate([
            'newEmployee.id' => 'required|min:18|max:18|string|unique:employees,id',
            'newEmployee.name' => 'required|min:5|max:50|string',
        ], [
            'newEmployee.id.required' => 'NIP is required',
            'newEmployee.id.unique' => 'NIP already exists',
            'newEmployee.id.min' => 'NIP must be 18 characters',
            'newEmployee.name.required' => 'Name is required',
        ]);

        Employee::create([
            'id' => $this->newEmployee['id'],
            'name' => $this->newEmployee['name'],
            // default avatar
            'avatar' => 'avatars/01.png'
        ]);

        $this->success('Employee created successfully.', 'Success!!', position: 'toast-bottom');
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
        return view('livewire.components.employee.table', [
            'employees' => $this->employees(),
            'headers' => $this->headers,
            'sortBy' => $this->sortBy
        ]);
    }
}
