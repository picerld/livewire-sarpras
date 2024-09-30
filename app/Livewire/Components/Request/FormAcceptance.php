<?php

namespace App\Livewire\Components\Request;

use App\Models\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Mary\Traits\Toast;

class FormAcceptance extends Component
{
    use Toast;

    public $requestCode;
    public Request $request;

    public function mount($requestCode): void
    {
        $this->requestCode = $requestCode;
        $this->request = Request::where('id', $this->requestCode)->first();
    }

    public function updateStatus(string $status): void
    {
        $this->request->update(['status' => $status]);
        
        $message = $status === 'accepted' ? 'Approved successfully!' : 'Rejected successfully!';
        $this->success($message, 'Success!', redirectTo: "/requests/" . $this->request->id, position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.components.request.form-acceptence');
    }
}
