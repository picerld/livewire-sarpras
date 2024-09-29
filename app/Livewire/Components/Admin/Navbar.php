<?php

namespace App\Livewire\Components\Admin;

use App\Models\Notification as ModelsNotification;
use Livewire\Component;
use Mary\Traits\Toast;

class Navbar extends Component
{
    use Toast;

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

    // FIX THIS ON UPDATE NOTIFICATION, IT WILL REFRESH THE PAGE!!
    public function read($id): void
    {
        ModelsNotification::where('id', $id)->update(['read_at' => now()]);

        // $this->success('Success', 'Notification has been read', redirectTo: url()->current(), position: 'bottom-end');
        // return redirect(url()->current());
    }

    public function render() {
        return view('livewire.components.admin.navbar');
    }
}
