<?php

namespace App\Livewire\Components\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mary\Traits\Toast;

class FormInput extends Component
{
    use Toast;

    // data category
    public $newCategory = [
        'name' => '',
        'aliases' => '',
    ];

    // CRUD
    public function store()
    {
        $validator = Validator::make(
            $this->newCategory,
            [
                'name' => 'required|string|max:50|min:4|unique:category,name',
                'aliases' => 'required|string|max:6|min:2|unique:category,aliases'
            ]
        );

        if ($validator->fails()) {
            $this->warning($validator->errors()->first(), 'Warning!!', position: 'toast-bottom');
            return;
        }

        $validated = $validator->validated();

        Category::create($validated);
        $this->success("Category successfully created!", 'Success!', redirectTo: '/category', position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.components.category.form-input');
    }
}
