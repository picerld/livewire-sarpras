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
            ->when($this->search, fn (Builder $q) => $q->whereAny(['name', 'email', 'role'], 'LIKE', "%$this->search%"))
            ->get();
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
                'name' => 'Pengawas'
            ],
            [
                'id' => '3',
                'name' => 'Unit'
            ]

        ];


        return view('livewire.components.account.list-item', [
            'users' => $this->users(),
            'roles' => $roles
        ]);
    }
}
