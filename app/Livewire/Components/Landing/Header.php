<?php

namespace App\Livewire\Components\Landing;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public $value = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        if (Auth::check()) {
            $this->value = Cart::where('nip', Auth::user()->nip)->count();
        }
    }
    
    public function updateCartCount($count)
    {
        $this->value = $count;
    }

    public function render()
    {
        return view('livewire.components.landing.header');
    }
}
