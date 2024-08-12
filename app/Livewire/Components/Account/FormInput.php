<?php

namespace App\Livewire\Components\Account;

use App\Helpers\GenerateCodeHelper;
use App\Models\Employee;
use App\Models\User;
use GMP;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mary\Traits\Toast;

class FormInput extends Component
{
    use Toast;

    public $newUser = [
        'id' => '',
        'username' => '',
        'password' => '',
        'role' => '',
        'nip' => ''
    ];

    public $employees;
    public User $user;
    public function mount()
    {
        $this->user = new User();

        $employees = Employee::all();
        $this->employees = $employees;
    }

    public function store(): void
    {
        $this->newUser['id'] = GenerateCodeHelper::handleGenerateCode();
        $validator = Validator::make($this->newUser, [
            'id' => 'required|max:20|unique:users,id|min:5',
            'username' => 'required|email|unique:users,username',
            'password' => 'required|min:8',
            'role' => 'required',
            'nip' => 'required|unique:users,nip'
        ]);
        
        
        if ($validator->fails()) {
            $this->error($validator->errors()->first(), 'Failed!', redirectTo: '/users', position: 'toast-bottom');
            return;
        }
        
        $validated = $validator->validated();
       
        $this->user->create($validated);
        
        $this->success("User successfully created!", 'Success!', redirectTo: '/users', position: 'toast-bottom');
    }
    public function render()
    {
        // manualy option role
        $role = [
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
            ],
        ];
        return view('livewire.components.account.form-input', [
            'role' => $role
        ]);
    }
}
