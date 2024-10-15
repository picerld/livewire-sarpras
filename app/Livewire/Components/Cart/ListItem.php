<?php

namespace App\Livewire\Components\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListItem extends Component
{
    public $items;
    public $totalQty;

    public function mount()
    {
        $this->items = Cart::where('nip', Auth::user()->nip)->get();
        $this->totalQty = Cart::where('nip', Auth::user()->nip)->sum('qty');
    }

    public function render()
    {
        return view('livewire.components.cart.list-item');
    }
}
