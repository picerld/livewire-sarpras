<?php

namespace App\Livewire\Components\Admin;

use App\Models\Notification as ModelsNotification;
use Illuminate\Notifications\Notification;
use Livewire\Component;

class Navbar extends Component
{
    // navbar
    public $notif;
    public $notifications;
    public $brandName = 'Sarpras';


    public function mount(): void
    {
        // $this->notif = ModelsNotification::where('read_at', null)->count();
        $this->notif = ModelsNotification::where('read_at', null)->count();
        $this->notifications = ModelsNotification::where('read_at', null)->get();
    }

    public function render() {
        return view('livewire.components.admin.navbar');
    }
}
