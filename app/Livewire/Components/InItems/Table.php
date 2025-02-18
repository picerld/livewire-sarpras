<?php

namespace App\Livewire\Components\InItems;

use App\Exports\incomingItemExport;
use App\Helpers\ImageHelper;
use App\Models\IncomingItem;
use App\Models\IncomingItemDetail;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast, WithFileUploads;

    // header table
    public $headers = [
        ['key' => 'users_name', 'label' => 'Petugas', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'suppliers_name', 'label' => 'Supplier', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'total_items', 'label' => 'Total Item', 'class' => 'dark:text-slate-300 text-center text-sm'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300 text-sm'],
    ];

    public int $perPage = 5;

    public $itemIn;
    public $itemInDetail;

    #[Rule('nullable|image|max:10')]
    public $newIncomingItem = [
        'image' => ""
    ];

    public $image = "";

    public function mount()
    {
        $this->image = $this->newIncomingItem['image'];
    }

    // search
    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createItems = false;
    public bool $inItemImage = false;
    public bool $inItemExportPdf = false;

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

    public function inItemImageModal($id)
    {
        $this->inItemImage = true;
        $this->itemInDetail = IncomingItem::find($id);
    }

    public function inItemCsvModal()
    {
        $this->inItemExportPdf = true;
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

    public function save()
    {
        $this->validate([
            'newIncomingItem.image' => 'required|image|max:2048',
        ], [
            'newIncomingItem.image.required' => 'Image is required',
        ]);

        if (!empty($this->newIncomingItem['image'])) {
            $url = ImageHelper::handleImage($this->newIncomingItem['image']);

            if ($url) {
                if (!empty($this->itemInDetail->image) && $this->itemInDetail->image !== $url) {
                    Storage::delete($this->itemInDetail->image);
                }

                $this->itemInDetail->update(['image' => $url]);
            }
        }

        $this->success('Item image updated', 'Good bye!', position: 'toast-bottom');
        $this->inItemImage = false;
        $this->newIncomingItem = ['image' => ""];
    }

    public function exportCsv()
    {
        return Excel::download(new incomingItemExport, 'incoming-items-' . Date::now()->format('dmYHms') . '.xlsx');
    }

    public function render()
    {
        $itemsIn = $this->itemsIn();
        $suppliers = Supplier::all();

        // manualy option role
        $users = User::where('role', '!=', 'unit')->get();

        $users = $users->map(function (User $user) {
            return [
                'id' => $user->nip,
                'name' => $user->employee->name
            ];
        });

        return view('livewire.components.in-items.table', [
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'itemsIn' => $itemsIn,
            'itemInDetail' => $this->itemInDetail,
            'users' => $users,
            'suppliers' => $suppliers
        ]);
    }
}
