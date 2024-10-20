<?php

namespace App\Livewire\Components\Cart;

use App\Helpers\GenerateCodeHelper;
use App\Models\Cart;
use App\Models\Submission;
use App\Models\SubmissionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mary\Traits\Toast;

class ListItem extends Component
{
    use Toast;

    public $items;
    public $totalQty;

    // store to submission
    public $regarding;

    public function mount()
    {
        $this->items = Cart::where('nip', Auth::user()->nip)->get();
        $this->totalQty = Cart::where('nip', Auth::user()->nip)->sum('qty');
    }

    public function delete(Cart $cart): void
    {
        $cart->delete();
        $this->success("Item successfully deleted!", 'Success!', redirectTo: route('carts.index'), position: 'toast-bottom');
    }

    public function store(): void
    {
        $validator = Validator::make([
            'regarding' => $this->regarding,
            'items' => $this->items,
        ], [
            'regarding' => 'required|string|min:5|max:200',
            'items' => 'required',
        ], [
            'regarding.required' => 'Perihal harus diisi',
            'regarding.min' => 'Perihal minimal 5 karakter',
            'items.required' => 'Belum ada item!',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first(), 'Warning!!', position: 'toast-bottom');
            return;
        }

        $submission = Submission::create([
            'id' => GenerateCodeHelper::handleGenerateCode(),
            'nip' => Auth::user()->nip,
            'status' => 'pending',
            'regarding' => $this->regarding,
            'total_items' => 0,
        ]);

        $totalItems = 0;

        foreach ($this->items as $item) {
            SubmissionDetail::create([
                'id' => GenerateCodeHelper::handleGenerateCode(),
                'submission_code' => $submission->id,
                'item_code' => $item->item_code,
                'qty' => $item->qty,
                'qty_accepted' => 0,
            ]);

            $totalItems += $item->qty;

            $item->delete();
        }

        $submission->update([
            'total_items' => $totalItems,
        ]);

        $this->success('Submission successfully created!', 'Success!', redirectTo: route('carts.index'), position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.components.cart.list-item');
    }
}
