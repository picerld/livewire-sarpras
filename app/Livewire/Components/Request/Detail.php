<?php

namespace App\Livewire\Components\Request;

use App\Models\RequestDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class Detail extends Component
{
    use Toast;

    public $requestApproved = [
        'qty' => null,
    ];

    public $requests;
    public $requestCode;

    public $requestItem;
    public $requestDetailCode;

    public $item;

    public bool $approvalModal = false;

    public function mount($requestCode): void
    {
        $this->requestCode = $requestCode;
        $this->requests = RequestDetail::where('request_code', $this->requestCode)->get();
    }

    public function approval($requestDetailCode): void
    {
        $this->approvalModal = true;

        $this->requestDetailCode = $requestDetailCode;
        $this->requestItem = RequestDetail::where('id', $this->requestDetailCode)->first();
    }

    public function save(RequestDetail $requestDetail): void
    {
        $item = $this->requestItem->item;

        // check if stock is 0 
        if ($this->requestItem->item->stock == 0) {
            $this->approvalModal = false;
            $this->error("Stok untuk $item->name habis!", 'Oops!', position: 'toast-bottom');
            return;
        }

        $requestDetail = RequestDetail::find($requestDetail->id);

        $this->validate([
            'requestApproved.qty' => 'required|numeric|min:1',
        ]);

        // check if qty approved is greater than qty item
        if ($this->requestApproved['qty'] > $this->requestItem->qty || $this->requestApproved['qty'] > $item->stock) {
            $this->approvalModal = false;
            $this->error('Jumlah tidak boleh lebih dari yang seharusnya!', 'Oops!', position: 'toast-bottom');
            return;
        }

        if ($requestDetail) {
            $requestDetail->update([
                'qty_accepted' => $this->requestApproved['qty'],
                'accepted_by' => Auth::user()->id,
            ]);

            $requestDetail->item->update([
                'stock' => $requestDetail->item->stock - $requestDetail->qty_accepted
            ]);
        }

        // validate if stock < stock min
        if ($item->stock <= $item->minimum_stock) {
            $this->approvalModal = false;
            $this->warning("Jumlah stock $item->name, kurang dari stock minimum!", 'Success!', redirectTo: "/requests/{$this->requestCode}", position: 'toast-bottom');
            return;
        }

        $this->success('Approved successfully!', 'Success!', redirectTo: "/requests/{$this->requestCode}", position: 'toast-bottom');
        $this->approvalModal = false;
    }

    public function render()
    {
        return view('livewire.components.request.detail');
    }
}
