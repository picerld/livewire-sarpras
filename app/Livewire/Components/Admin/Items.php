<?php

namespace App\Livewire\Components\Admin;

use Livewire\Component;

class Items extends Component
{
    public $title;
    public $link;
    public $model;

    public function mount($link, $title, $model)
    {
        $this->title = $title;
        $this->link = $link;
        $this->model = $model;
    }

    public function datas()
    {
        $modelClass = '\\App\\Models\\' . $this->model;
        if (class_exists($modelClass)) {
            return $modelClass::inRandomOrder();
        } else {
            return collect();
        }
    }

    public function render()
    {
        $datas = $this->datas();

        return view('livewire.components.admin.items', [
            "datas" => $datas->paginate(3)
        ]);
    }
}