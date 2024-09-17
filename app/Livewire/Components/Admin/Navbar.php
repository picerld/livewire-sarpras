<?php

namespace App\Livewire\Components\Admin;

use App\Models\Notification as ModelsNotification;
use App\Models\Submission;
use Illuminate\Notifications\Notification;
use Livewire\Component;

class Navbar extends Component
{
    // navbar
    public $brandName = 'Sarpras';
    public $notif;

    public function mount($notif): void
    {
        // $this->notif = ModelsNotification::where('read_at', null)->count();
        $this->notif = Submission::where('status', 'pending')->count();
    }

    public function render() {
        return view('livewire.components.admin.navbar');
    }
}
