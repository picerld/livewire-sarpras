<?php

namespace App\Livewire\Components\Request;

use App\Helpers\GenerateCodeHelper;
use App\Models\OutgoingItem;
use App\Models\OutgoingItemDetail;
use App\Models\Request;
use App\Models\RequestDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Mary\Traits\Toast;

class Detail extends Component
{
    use Toast;

    public $requestApproved = [
        'qty' => null,
    ];

    public $requests;
    public $nip;
    public $requestCode;

    public $requestItem;
    public $requestDetailCode;

    public $item;

    public bool $approvalModal = false;

    public function mount($requestCode): void
    {
        $this->requestCode = $requestCode;
        $this->requests = RequestDetail::where('request_code', $this->requestCode)->orderBy('qty_accepted', 'ASC')->get();
        $this->nip = Request::where('id', $this->requestCode)->first()->nip;
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

        // STORE TO OUTGOING AND DETAIL TABLE
        $this->createOutgoingItem($requestDetail);

        // validate if stock < stock min
        if ($item->stock <= $item->mxinimum_stock) {
            $this->approvalModal = false;
            $this->warning("Jumlah stock $item->name, kurang dari stock minimum!", 'Success!', redirectTo: "/requests/{$this->requestCode}", position: 'toast-bottom');
        }

        $this->success('Approved successfully!', 'Success!', redirectTo: "/requests/{$this->requestCode}", position: 'toast-bottom');
        $this->approvalModal = false;
    }

    private function createOutgoingItem($requestDetail): void
    {
        $outgoingItem = OutgoingItem::where('request_code', $requestDetail->request_code)->first();

        if (!$outgoingItem) {
            $outgoingItem = OutgoingItem::create([
                'id' => GenerateCodeHelper::handleGenerateCode(),
                'request_code' => $requestDetail->request_code,
                'nip' => $this->nip,
                'total_items' => $this->requestApproved['qty'],
            ]);
            $this->createOutgoingItemDetail($outgoingItem, $requestDetail->item);
            return;
        }

        $this->createOutgoingItemDetail($outgoingItem, $requestDetail->item);
    
        $outgoingItem->update([
            'total_items' => $outgoingItem->total_items + $this->requestApproved['qty'],
        ]);
    }
    
    private function createOutgoingItemDetail($outgoingItem, $item): void
    {
        OutgoingItemDetail::create([
            'id' => GenerateCodeHelper::handleGenerateCode(),
            'outgoing_item_code' => $outgoingItem->id,
            'item_code' => $item->id,
            'qty' => $this->requestApproved['qty'],
        ]);
    }

    public function render()
    {
        return view('livewire.components.request.detail');
    }
}
