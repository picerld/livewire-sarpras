<?php

namespace App\Livewire\Components\Supplier;

use App\Helpers\GenerateCodeHelper;
use App\Models\Supplier;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'name', 'label' => 'Nama', 'class' => 'dark:text-slate-300'],
        ['key' => 'address', 'label' => 'Alamat', 'class' => 'dark:text-slate-300',],
        ['key' => 'created_at', 'label' => 'Tanggal bergabung', 'class' => 'dark:text-slate-300'],
    ];

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    public $newSupplier = [
        'name' => '',
        'address' => '',
    ];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createSuppliers = false;

    public $fromDate = null;
    public $toDate = null;

    public function tableDrawer()
    {
        $this->drawerIsOpen = true;
    }

    public function createSuppliersModal()
    {
        $this->createSuppliers = true;
    }

    public function suppliers(): LengthAwarePaginator
    {
        return Supplier::query()
            ->when($this->search, fn (Builder $query) => $query->whereAny(['name', 'address'], 'like', '%' . $this->search . '%'))
            ->when($this->fromDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $this->toDate))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5, ['id', 'name', 'address', 'created_at']);
    }

    public function store(): void
    {
        $this->validate([
            'newSupplier.name' => 'required|string|min:4|max:50',
            'newSupplier.address' => 'required|string|min:5|max:50'
        ], [
            'newSupplier.name.required' => 'Supplier name is required',
            'newSupplier.address.required' => 'Supplier address is required',
        ]);

        Supplier::create([
            'name' => $this->newSupplier['name'],
            'address' => $this->newSupplier['address'],
        ]);

        $this->success('Supplier created', 'Good bye!', redirectTo: '/suppliers', position: 'toast-bottom');
        $this->createSuppliers = false;
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

    public function delete(Supplier $supplier): void
    {
        $supplier->delete();
        $this->success("Supplier $supplier->name deleted", 'Good bye!', redirectTo: '/suppliers', position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.components.supplier.table', [
            'suppliers' => $this->suppliers(),
            'headers' => $this->headers,
            'sortBy' => $this->sortBy
        ]);
    }
}
