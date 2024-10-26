<?php

namespace App\Livewire\Components\Unit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class Stats extends Component
{
    public $title;
    public $model;
    public $icon;
    public $value;
    public $description;

    public function mount($title, $model, $icon)
    {
        $modelClass = '\App\Models\\' . $model;

        if ($model && Schema::hasColumn((new $modelClass)->getTable(), 'total_items')) {
            $this->value = $modelClass::where('nip', Auth::user()->nip)
                ->whereYear('created_at', '=', date('Y'))
                ->count();

            $this->description =  $modelClass::where('nip', Auth::user()->nip)
                ->whereYear('created_at', '=', date('Y'))
                ->sum('total_items');
        } else {
            $this->value = $modelClass::count();
        }

        $this->title = $title;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('livewire.components.unit.stats');
    }
}
