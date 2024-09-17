<?php

namespace App\Livewire\Components\Request;

use App\Helpers\GenerateCodeHelper;
use App\Models\Item;
use App\Models\Request;
use App\Models\RequestDetail;
use App\Models\User;
use Livewire\Component;
use Mary\Traits\Toast;

class FormRequest extends Component
{
    use Toast;

    public Item $item;

    public $inputs = [['item_code' => '', 'qty' => 1]];

    public $items;
    public $requests;
    public $nip;
    public $regarding;
    public $characteristic;

    public $i = 1;

    public $search = "";

    public function mount(): void
    {
        $this->items = Item::all();
    }

    public function addInput()
    {
        // Add new input field on object
        $this->inputs[] = ['item_code' => '', 'qty' => 1];
    }

    public function removeInput($i)
    {
        // Remove input field on object based on index
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
    }

    public function store(): void
    {
        $this->validate([
            'nip' => 'required|exists:employees,id',
            'regarding' => 'required|string|min:10|max:50',
            'characteristic' => 'required|string|min:3|max:50',
            'inputs.*.item_code' => 'required|exists:items,id',
            'inputs.*.qty' => 'required|integer|min:1'
        ], [
            'regarding.required' => 'Keterangan harus diisi',
            'characteristic.required' => 'Sifat harus diisi',
            'nip.required' => 'Unit harus dipilih',
            'inputs.*.item_code.required' => 'Item harus dipilih',
            'inputs.*.qty.required' => 'Jumlah harus diisi',
            'inputs.*.qty.min' => 'Jumlah minimal 1',
        ]);

        $request = Request::create([
            'id' => GenerateCodeHelper::handleGenerateCode(),
            'nip' => $this->nip,
            'regarding' => $this->regarding,
            'total_items' => 0, // Default value
            'characteristic' => $this->characteristic
        ]);

        $totalItems = 0;
        foreach ($this->inputs as $input) {
            RequestDetail::create([
                'request_code' => $request->id,
                'item_code' => $input['item_code'],
                'qty_accepted' => 0,
                'accepted_by' => null,
                'qty' => $input['qty'],
            ]);
            $totalItems += $input['qty'];
        }

        $request->update([
            'total_items' => $totalItems
        ]);

        $this->success("Request successfully created", 'Success!!', position: 'toast-bottom', redirectTo: '/requests');
        $this->reset(['inputs', 'nip']);
    }

    public function render()
    {
        $users = User::withAggregate('employee', 'name')->get();

        // mapping users for select with 'nip' as 'id' an 'employee.name' as 'name' for value
        $userMap = $users->map(function (User $user) {
            return [
                'id' => $user->nip,
                'name' => $user->employee->name
            ];
        });

        return view('livewire.components.request.form-request', [
            'users' => $userMap
        ]);
    }
}
