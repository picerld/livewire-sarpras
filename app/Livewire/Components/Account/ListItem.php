<?php

namespace App\Livewire\Components\Account;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Mary\Traits\Toast;

class ListItem extends Component
{
    use Toast;

    public $search = "";

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createUsers = false;

    //filters
    public $selectedRole = null;
    public $fromDate = null;
    public $toDate = null;

    public function drawerList()
    {
        $this->drawerIsOpen = true;
    }

    public function userModal()
    {
        $this->createUsers = true;
    }

    public function users()
    {
        return User::query()
            ->withAggregate('employee', 'name')
            ->when($this->search, function (Builder $query) {
                $query->whereHas('employee', function (Builder $query) {
                    $query->where('name', 'LIKE', "%$this->search%");
                })
                    ->orWhere('username', 'LIKE', "%$this->search%")
                    ->orWhere('role', 'LIKE', "%$this->search%");
            })
            ->when($this->selectedRole, fn (Builder $q) => $q->where('role', $this->selectedRole))
            ->when($this->fromDate, fn (Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn (Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->get();
    }

    public function clear(): void
    {
        $this->reset();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    public function delete(User $user): void
    {
        $user->delete();
        $this->success("User $user->name successfully deleted!!", 'Good bye!!', position: 'toast-bottom');
    }

    public function render()
    {
        // manualy option role
        $roles = [
            [
                'id' => '1',
                'name' => 'Admin'
            ],
            [
                'id' => '2',
                'name' => 'Unit'
            ],
            [
                'id' => '3',
                'name' => 'Pengawas'
            ],

        ];

        return view('livewire.components.account.list-item', [
            'users' => $this->users(),
            'roles' => $roles
        ]);
    }
}
