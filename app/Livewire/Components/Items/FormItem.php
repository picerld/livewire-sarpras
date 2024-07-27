<?php

namespace App\Livewire\Components\Items;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mary\Traits\Toast;

class FormItem extends Component
{
    use Toast;

    public Item $item;

    public $newItem = [
        'name' => '',
        'code' => '',
        'unit' => '',
        'merk' => '',
        'price' => '',
        'stock' => '',
        'minimum_stock' => '',
        'category_id' => '',
        'description' => ''
    ];

    public $itemID;

    public function mount($itemID): void
    {
        $this->itemID = $itemID;
        $this->item = Item::findOrFail($this->itemID);
        $this->fillItem();
    }

    public function fillItem(): void
    {
        $this->newItem = [
            'name' => $this->item->name,
            'code' => $this->item->code,
            'unit' => $this->item->unit,
            'merk' => $this->item->merk,
            'price' => $this->item->price,
            'stock' => $this->item->stock,
            'minimum_stock' => $this->item->minimum_stock,
            'category_id' => $this->item->category_id,
            'description' => $this->item->description
        ];
    }

    public function save(Item $item): void
    {
        try {
            $validator = Validator::make(
                $this->newItem,
                [
                    'name' => 'required|string|max:255',
                    'merk' => 'required|string|max:255',
                    'unit' => 'required|string|max:50',
                    'price' => 'required|numeric|min:0',
                    'stock' => 'required|integer|min:1',
                    'minimum_stock' => 'required|integer|min:1',
                    'category_id' => 'required|exists:category,id',
                    'description' => 'required|string|max:100'
                ]
            );

            $this->item->update($validator->validated());

            $this->success(
                "Item $item->name updated!",
                "Success!!",
                redirectTo: '/items',
                position: 'toast-bottom'
            );
        } catch (\Throwable $th) {
            $this->warning($validator->errors()->first(), 'Warning!!', position: 'toast-bottom');
        }
    }

    public function render()
    {
        $categories = Category::all();

        return view('livewire.components.items.form-item', [
            "categories" => $categories
        ]);
    }
}
