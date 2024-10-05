<?php

namespace App\Livewire\Components\Submission;

use App\Models\Submission;
use App\Models\SubmissionDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class Detail extends Component
{
    use Toast;

    public $submissionApproved = [
        'qty' => null,
    ];

    // props from parent
    public $submissions;
    public $submissionCode;

    // props from child
    public $submissionItem;
    public $submissionDetailCode;

    // props item
    public $item;

    // modal
    public bool $approvalModal = false;

    public function mount($submissionCode): void
    {
        $this->submissionCode = $submissionCode;
        $this->submissions = SubmissionDetail::where('submission_code', $this->submissionCode)->orderBy('qty_accepted', 'ASC')->get();
    }

    // business accept
    public function approval($submissionDetailCode): void
    {
        $this->approvalModal = true;

        $this->submissionDetailCode = $submissionDetailCode;
        $this->submissionItem = SubmissionDetail::where('id', $this->submissionDetailCode)->first();
    }

    public function save(SubmissionDetail $submissionDetail): void
    {
        $submissionDetail = SubmissionDetail::find($submissionDetail->id);

        $this->validate([
            'submissionApproved.qty' => 'required|numeric|min:1',
        ]);

        // check if qty approved is greater than qty item
        if ($this->submissionApproved['qty'] > $this->submissionItem->qty) {
            $this->approvalModal = false;
            $this->error('Jumlah tddak boleh lebih dari yang seharusnya!', 'Oops!', position: 'toast-bottom');
            return;
        }

        if ($submissionDetail) {
            $submissionDetail->update([
                'qty_accepted' => $this->submissionApproved['qty'],
                'accepted_by' => Auth::user()->id,
            ]);

        }

        $this->approvalModal = false;
        $this->success('Approved successfully!', 'Success!', redirectTo: "/submissions/{$this->submissionCode}", position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.components.submission.detail', [
            'submissionItem' => $this->submissionItem
        ]);
    }
}
