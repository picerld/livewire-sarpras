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
        // generate model from param
        $modelClass = '\\App\\Models\\' . $this->model;
        if (class_exists($modelClass)) {
            // data random
            return $modelClass::orderBy('status' , 'ASC')->paginate(5);
        } else {
            return collect();
        }
    }

    public function render()
    {
        $datas = $this->datas();

        return view('livewire.components.admin.items', [
            "datas" => $datas
        ]);
    }
}
