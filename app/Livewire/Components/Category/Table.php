<?php

namespace App\Livewire\Components\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    // header table
    public $headers = [
        ['key' => 'name', 'label' => 'Nama', 'class' => 'dark:text-slate-300 text-sm'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300 text-sm'],
    ];

    // filters
    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    public function category(): LengthAwarePaginator
    {
        return Category::query()
            ->when($this->search, fn (Builder $query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5, ['id', 'name', 'created_at']);
    }

    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function delete(Category $category): void
    {
        $category->delete();
        $this->success("$category->name successfully deleted!!", 'Good bye!', position: 'toast-bottom');
    }

    public function render()
    {
        $category = $this->category();
        
        return view('livewire.components.category.table', [
            'category' => $category
        ]);
    }
}
