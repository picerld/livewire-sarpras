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

    public $selectedItemTab = "existing-item-tab";

    public $inputs = [['item_code' => '', 'qty' => 1]];
    public $inputNewItems = [['custom_item' => '', 'custom_item_qty' => 1]];

    public $submissions;

    public $nip;
    public $items;
    public $regarding;

    // message on status 'rejected' or 'accepted'
    public $statusNote;

    // index
    public $i = 1;

    // search
    public $search = "";

    public function mount(): void
    {
        $this->items = Item::all();
    }

    public function addInput($subject)
    {
        if ($subject == 'exist-item') {
            $this->inputs[] = ['item_code' => '', 'qty' => 1];
            return;
        }

        $this->inputNewItems[] = ['custom_item' => '', 'custom_item_qty' => 1];
    }

    public function removeInput($subject, $i)
    {
        if ($subject == 'exist-item') {
            unset($this->inputs[$i]);
            $this->inputs = array_values($this->inputs);
            return;
        }
        
        unset($this->inputNewItems[$i]);
        $this->inputNewItems = array_values($this->inputNewItems);
    }

    public function store(): void
    {
        // Validate input data
        $this->validate([
            'nip' => 'required|exists:employees,id',
            'regarding' => 'required|string|min:10|max:50',
            'inputs.*.item_code' => 'nullable|exists:items,id',
            'inputs.*.qty' => 'integer|min:1',
            'inputNewItems.*.custom_item' => 'nullable|string|min:3|max:50',
            'inputNewItems.*.custom_item_qty' => 'integer|min:1',
        ], [
            'nip.required' => 'Unit harus dipilih',
            'regarding.required' => 'Keterangan harus diisi',
            'inputs.*.qty.min' => 'Jumlah minimal 1',
            'inputNewItems.*.custom_item.min' => 'Minimal 3 karakter',
            'inputNewItems.*.custom_item_qty.min' => 'Jumlah minimal 1',
        ]);

        // store to submission table
        $submission = Submission::create([
            'id' => GenerateCodeHelper::handleGenerateCode(),
            'nip' => $this->nip,
            'regarding' => $this->regarding,
            'total_items' => 0,
        ]);

        $user = User::where('nip', $this->nip)->first();
        $user->notify(new ConfirmSubmission($this->nip, $this->regarding, $submission));

        $totalItems = 0;

        // if there is existing item
        foreach ($this->inputs as $input) {
            if (!empty($input['item_code'])) {
                SubmissionDetail::create([
                    'submission_code' => $submission->id,
                    'item_code' => $input['item_code'],
                    'qty_accepted' => 0,
                    'accepted_by' => null,
                    'qty' => $input['qty'],
                    'status_note' => null,
                    'custom_item' => null,
                ]);
                $totalItems += $input['qty'];
            }
        }

        // if there is custom item
        foreach ($this->inputNewItems as $newItem) {
            if (!empty($newItem['custom_item'])) {
                SubmissionDetail::create([
                    'submission_code' => $submission->id,
                    'item_code' => null,
                    'qty_accepted' => 0,
                    'accepted_by' => null,
                    'qty' => $newItem['custom_item_qty'],
                    'status_note' => null,
                    'custom_item' => $newItem['custom_item_qty'],
                ]);
                $totalItems += $newItem['custom_item_qty'];
            }
        }

        $submission->update([
            'total_items' => $totalItems,
        ]);

        $this->success("Pengajuan successfully created", "Success!!", position: 'toast-bottom', redirectTo: '/submissions');
        $this->reset(['inputs', 'nip']);
    }

    public function render()
    {
        $users = User::withAggregate('employee', 'name')->get();

        // mapping users for select with 'nip' as 'id' an 'employee.name' as 'name' for value
        $userMap = $users->map(function (User $user) {
            return [
                'id' => $user->nip,
                'name' => trim(explode('@', $user->username)[0]),
            ];
        });

        return view('livewire.components.submission.form-submission', [
            'users' => $userMap
        ]);
    }
}
