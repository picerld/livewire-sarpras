<?php

namespace App\Livewire\Components\Supplier;

use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mary\Traits\Toast;

class FormSupplier extends Component
{
    use Toast;

    public $supplierId;
    public Supplier $supplier;

    public $newSupplier = [
        'id' => '',
        'name' => '',
        'address' => '',
    ];

    public function fillItem(): void
    {
        $this->newSupplier = $this->supplier->only([
            'name',
            'address',
        ]);
    }

    public function mount($supplierId)
    {
        $this->supplierId = $supplierId;
        $this->supplier = Supplier::findOrFail($this->supplierId);

        $this->fillItem();
    }

    public function save(): void
    {
        try {
            $validator = Validator::make($this->newSupplier, [
                'name' => 'required|string|max:255|min:5',
                'address' => 'required|string|max:255|min:5',
            ]);

            $validated = $validator->validated();
            if ($validator->fails()) {
                $this->warning($validator->errors()->first(), 'Warning!!', position: 'toast-bottom');
                return;
            }

            $this->supplier->update($validated);
            $this->success('Supplier updated', 'Good bye!', position: 'toast-bottom');
        } catch (\Throwable $th) {
            $this->warning($th->getMessage(), 'Warning!!', position: 'toast-bottom');
        }
    }

    public function delete(Supplier $supplier): void
    {
        $supplier->delete();
        $this->success('Supplier $supplier->name deleted', 'Good bye!', redirectTo: route('suppliers.index'), position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.components.supplier.form-supplier');
    }
}
