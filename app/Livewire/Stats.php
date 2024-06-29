<?php

namespace App\Livewire;

use Livewire\Component;

class Stats extends Component
{
    public $title;
    public $model;
    public $value;
    public $description;
    public $icon;
    public $class;

    public function mount($title, $model, $icon) {
        $modelClass = '\App\Models\\' . $model;

        $this->value = $model ? $modelClass::count() : $title;
        $this->title = $title;
        $this->icon = $icon;
    }

    public function render() {
        return view('livewire.stats');
    }
}
