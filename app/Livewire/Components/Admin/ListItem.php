<?php

namespace App\Livewire\Components\Admin;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class ListItem extends Component
{
    // search
    public $search = "";

    public function users()
    {
        $users = User::query()
            ->withAggregate('employee', 'name')
            ->when($this->search, function (Builder $query) {
                $query->whereHas('employee', function (Builder $query) {
                    $query->where('name', 'LIKE', "%$this->search%");
                })
                    ->orWhere('username', 'LIKE', "%$this->search%")
                    ->orWhere('role', 'LIKE', "%$this->search%");
            })
            ->paginate(5);

        return $users;
    }

    public function clear(): void
    {
        $this->reset();
    }

    public function render()
    {
        $users = $this->users();

        return view('livewire.components.admin.list-item', [
            'users' => $users,
        ]);
    }
}
