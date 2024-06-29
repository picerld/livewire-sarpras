<?php

namespace App\Livewire\Utils;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class Table extends Component
{
    use WithPagination;

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'dark:text-slate-300', 'sortable' => false],
        ['key' => 'nama', 'label' => 'Nama', 'class' => 'dark:text-slate-300',],
        ['key' => 'email', 'label' => 'Email', 'class' => 'dark:text-slate-300', 'sortable' => false],
        ['key' => 'role', 'label' => 'Role', 'class' => 'dark:text-slate-300', 'sortable' => false]
    ];

    public $search = '';
    public $sortBy = ['column' => 'nama', 'direction' => 'asc'];

    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->when($this->search, fn(Builder $q) => $q->whereAny(['nama', 'email', 'role'], 'LIKE', "%$this->search%"))
            ->orderBy('id', 'asc')
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5);
    }

    public function render()
    {
        $users = $this->users();
        // dd($users);

        return view('livewire.utils.table', [
            'users' => $users,
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
        ]);
    }
}
