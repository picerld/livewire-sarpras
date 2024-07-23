<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class NavLink extends Component
{
    public $title;
    public $icon;
    public $link;

    public function mount($title, $icon, $link) {
        $this->title = $title;
        $this->icon = $icon;
        $this->link = $link;
    }

    public function isActive() {
        return request()->routeIs($this->link);
    }

    public function render() {
        return view('livewire.utils.nav-link');
    }
}
