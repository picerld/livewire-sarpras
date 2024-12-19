<?php

namespace App\Livewire\Layouts\Supplier;

use App\Models\Supplier;
use Livewire\Component;

class Show extends Component
{
    public $supplier;
    public $supplierId;

    public function mount($supplierId)
    {
        $this->supplierId = $supplierId;
        $this->supplier = Supplier::findOrFail($this->supplierId);
    }

    public function render()
    {
        return view('livewire.layouts.supplier.show');
    }
}
