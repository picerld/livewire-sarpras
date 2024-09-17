<?php

namespace App\Livewire\Layouts\Request;

use App\Models\RequestDetail;
use Livewire\Component;

class Show extends Component
{
    public $requests;
    public $requestCode;

    public function mount($requestCode)
    {
        $this->requestCode = $requestCode;
        $this->requests = RequestDetail::where('request_code', $this->requestCode)->get();
    }

    public function render()
    {
        return view('livewire.layouts.request.show');
    }
}
