<?php

namespace App\Livewire\Components\Submission;

use App\Helpers\GenerateCodeHelper;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Submission;
use App\Models\SubmissionDetail;
use App\Models\User;
use App\Notifications\ConfirmSubmission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class FormSubmission extends Component
{
    use Toast;

    public Item $item;

    // Default value for inputs
    // it will be
    // [
    //  0 => ['item_id' => '', 'qty' => 1], 
    //  1 => ['item_id' => '', 'qty' => 1]
    // ] ... 
    public $inputs = [['item_code' => '', 'qty' => 1]];

    public $items;
    public $submissions;
    public $nip;
    public $regarding;

    // index
    public $i = 1;

    // search
    public $search;

    public function mount()
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
        // try {
        // Validate input data
        $this->validate([
            'nip' => 'required|exists:employees,id',
            'regarding' => 'required|string|min:10|max:50',
            'inputs.*.item_code' => 'required|exists:items,id',
            'inputs.*.qty' => 'required|integer|min:1'
        ], [
            'regarding.required' => 'Keterangan harus diisi',
            'nip.required' => 'Unit harus dipilih',
            'inputs.*.item_code.required' => 'Item harus dipilih',
            'inputs.*.qty.required' => 'Jumlah harus diisi',
            'inputs.*.qty.min' => 'Jumlah minimal 1',
        ]);

        // store to submission_detail table
        $submission = Submission::create([
            'id' => GenerateCodeHelper::handleGenerateCode(),
            'nip' => $this->nip,
            'regarding' => $this->regarding,
            'total_items' => 0, // Default value
        ]);

        $user = User::find($this->nip);  // Assuming you're notifying a user
        $user->notify(new ConfirmSubmission($this->nip, $this->regarding, $submission));

        $totalItems = 0;

        foreach ($this->inputs as $input) {
            SubmissionDetail::create([
                'submission_code' => $submission->id,
                'item_code' => $input['item_code'],
                'qty_accepted' => 0,
                'accepted_by' => null,
                'qty' => $input['qty'],
            ]);

            $totalItems += $input['qty'];
        }

        $submission->update([
            'total_items' => $totalItems,
        ]);

        $this->success("Pengajuan Successfully Added", "Success!!", position: 'toast-bottom', redirectTo: '/submissions');
        $this->reset(['inputs', 'nip']);

        // } catch (\Throwable $th) {
        //     $this->error($th->getMessage(), "Failed!!", position: 'toast-bottom');
        // }
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

        return view('livewire.components.submission.form-submission', [
            'users' => $userMap
        ]);
    }
}
