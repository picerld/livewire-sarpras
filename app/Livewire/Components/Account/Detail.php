<?php

namespace App\Livewire\Components\Account;

use App\Models\User;
use Livewire\Component;

class Detail extends Component
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
        return view('livewire.components.account.detail');
    }
}
