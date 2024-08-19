<?php

namespace App\Livewire\Components\Account;

use App\Models\User;
use Livewire\Component;

class Detail extends Component
{
    public $user;
    public $userId;

    //tab
    public $selectedTab = 'users-tab';

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($this->userId);
    }
    public function render()
    {
        return view('livewire.components.account.detail');
    }
}
