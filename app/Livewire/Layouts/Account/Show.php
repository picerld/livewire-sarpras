<?php

namespace App\Livewire\Layouts\Account;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public $user;
    public $userID;

    public function mount($userID)
    {
        $this->userID = $userID;
        $this->user = User::findOrFail($this->userID);
    }

    public function render()
    {
        return view('livewire.layouts.account.show');
    }
}
