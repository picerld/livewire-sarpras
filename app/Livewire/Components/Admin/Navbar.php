<?php

namespace App\Livewire\Components\Admin;

use App\Models\Notification as ModelsNotification;
use App\Models\Submission;
use Livewire\Component;

class Navbar extends Component
{
    // navbar
    public $notif;
    public $notifications;
    public $brandName = 'Sarpras';

    public function mount(): void
    {
        $this->notif = Submission::where('status', 'pending')->count();
        // CHANGE TO SUBMISSON AND REQUEST MODEL
        $this->notifications = ModelsNotification::where('read_at', null)->get();
    }

    public function render() {
        return view('livewire.components.admin.navbar');
    }
}
