<?php

namespace App\Livewire\Components\Items;

use App\Helpers\ImageHelper;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class FormItem extends Component
{
    use Toast, WithFileUploads;

    public Item $item;

    // Default value for inputs
    public $newItem = [
        'name' => '',
        'code' => '',
        'unit' => '',
        'merk' => '',
        'price' => '',
        'stock' => '',
        'minimum_stock' => '',
        'category_id' => '',
        'description' => '',
        'images' => ''
    ];
<<<<<<< Updated upstream
    public $itemID;
=======

    public $itemCode;
>>>>>>> Stashed changes

    public function mount($itemID)
    {
        $this->itemID = $itemID;
        $this->item = Item::findOrFail($this->itemID);
        // Fill recent value from table
        $this->fillItem();
    }

    public function fillItem(): void
    {
        // Fill item
        $this->newItem = $this->item->only([
            'name', 'code', 'unit', 'merk', 'price', 'stock',
            'minimum_stock', 'category_id', 'description', 'images'
        ]);
    }

    // CRUD
    public function save(): void
    {
        try {
            // Validate input
            $validator = Validator::make(
                $this->newItem,
                [
                    'name' => 'required|string|max:255|min:5',
                    'merk' => 'required|string|max:255|min:5',
                    'unit' => 'required|string|max:50|min:2',
                    'price' => 'required|numeric|min:0',
                    'stock' => 'required|integer|min:1',
                    'minimum_stock' => 'required|integer|min:1',
                    'category_id' => 'required|exists:category,id',
                    'description' => 'required|string|max:300|min:10',
                    'images' => 'nullable',
                ]
            );
        
            $validated = $validator->validated();

            if($validator->fails()) {
                $this->warning($validator->errors()->first(), 'Warning!!', position: 'toast-bottom');
                return;
            }
        
            if (!empty($this->newItem['images'])) {
                // Handle the image upload and get the URL or path
                $url = ImageHelper::handleImage($this->newItem['images']);
        
                if ($url) {
                    // Delete the old image if it exists and is different from the new image
                    if ($this->item->images && $this->item->images !== $url) {
                        $oldImagePath = 'public/' . basename($this->item->images);
                        if (Storage::exists($oldImagePath)) {
                            Storage::delete($oldImagePath);
                        }
                    }
        
                    // Update the item with the new image URL or path
                    $validated['images'] = $url;
                }
            }
        
            // Update the item
            $this->item->update($validated);        
        
            // Update the item
            $this->item->update($validated);
        
            $this->success("Item {$this->item->name} updated!", "Success!!", position: 'toast-bottom');
        } catch (\Throwable $th) {            
            $this->warning($th->getMessage(), 'Warning!!', position: 'toast-bottom');
        }   
    }

    public function delete(Item $item): void
    {
        // Delete image from storage/public ...
        if ($item->images) {
            Storage::delete('public/' . $item->images);
        }
        $item->delete();
        $this->success("Item $item->name deleted", 'Good bye!', redirectTo: '/items', position: 'toast-bottom');
    }

    public function render()
    {
        $categories = Category::all();

        return view('livewire.components.items.form-item', [
            "categories" => $categories
        ]);
    }
}