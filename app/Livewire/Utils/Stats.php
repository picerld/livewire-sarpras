<?php

namespace App\Livewire\Utils;

use Illuminate\Support\Facades\Schema;
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

        if ($model && Schema::hasColumn((new $modelClass)->getTable(), 'total_items')) {
            $this->value = $modelClass::sum('total_items');
        } else {
            $this->value = $modelClass::count();
        }
        $this->title = $title;
        $this->icon = $icon;
    }

    public function render() {
        return view('livewire.utils.stats');
    }
}
