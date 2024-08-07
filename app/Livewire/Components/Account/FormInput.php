<?php

namespace App\Livewire\Components\Account;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mary\Traits\Toast;

class FormInput extends Component
{
    use Toast;

    public $newUser = [
        'email' => '',
        'password' => '',
        'role' => '',
        'employee_id' => ''
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
        $validator = Validator::make($this->newUser, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required',
            'employee_id' => 'required|unique:users,employee_id'
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
