<?php

namespace App\Livewire\Components\Account;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mary\Traits\Toast;

class FormProfile extends Component
{
    use Toast;

    public $userId;
    public User $user;

    public $newUser = [
        'username' => '',
        'password' => '',
    ];

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($this->userId);

        // Fill recent value from table
        $this->fillItem();
    }

    public function fillItem()
    {
        $this->newUser = $this->user->only([
            'username',
        ]);
    }

    public function save(): void
    {
        // REFACTOR
        
        // try {
        $validator = Validator::make($this->newUser, [
            'username' => 'required|string|max:50|min:5',
            'password' => 'nullable|min:8|max:20',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first(), 'Failed!', position: 'toast-bottom');
            return;
        }

        $this->newUser = $validator->validated();

        if (!empty($this->newUser['password']) && !Hash::check($this->newUser['password'], $this->user->password)) {
            $this->newUser['password'] = Hash::make($this->newUser['password']);
        } else {
            unset($this->newUser['password']);
        }


        $this->user->update($this->newUser);
        $this->success("Profile successfully updated!", 'Success!', redirectTo: "/users/{$this->userId}", position: 'toast-bottom');
        // } catch (\Throwable $th) {
        //     $this->error('username or password is not valid!', 'Failed!', position: 'toast-bottom');
        // }
    }

    public function render()
    {
        $roles = [
            [
                'id' => '1',
                'name' => 'Admin'
            ],
            [
                'id' => '2',
                'name' => 'Pengawas'
            ],
        ];

        return view('livewire.components.account.form-profile', [
            'roles' => $roles,
        ]);
    }
}
