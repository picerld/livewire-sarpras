<?php

namespace App\Livewire\Layouts\Account;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public $user;
    public $userId;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($this->userId);
    }

    public function render()
    {
        return view('livewire.layouts.account.show');
    }
}
