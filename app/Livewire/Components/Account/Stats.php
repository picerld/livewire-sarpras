<?php

namespace App\Livewire\Components\Account;

use App\Models\IncomingItem;
use App\Models\User;
use Livewire\Component;

class Stats extends Component
{
    public $userId;
    public IncomingItem $incomingItem;

    public function mount($userId)
    {
        $this->userId = $userId;
        // $this->incomingItem =  IncomingItem::where('nip', $this->userId)->get()->count();
        // dd($this->incomingItem);
    }

    public function render()
    {
        return view('livewire.components.account.stats');
    }
}
