<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;

class Card extends Component
{
    public $icon;
    public $title;
    public $description;

    public function mount($icon, $title, $description)
    {
        $this->icon = $icon;
        $this->title = $title;
        $this->description = $description;
    }

    public function render()
    {
        return view('livewire.components.landing.card');
    }
}
