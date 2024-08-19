<?php

namespace App\Livewire\Components\Submission;

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

    //
    public $item;

    // modal
    public bool $approvalModal = false;

    public function mount($submissionCode): void
    {
        $this->submissionCode = $submissionCode;
        $this->submissions = SubmissionDetail::where('submission_code', $this->submissionCode)->get();
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

        if ($submissionDetail) {
            $submissionDetail->update([
                'qty_accepted' => $this->submissionApproved['qty'],
                'accepted_by' => Auth::user()->id,
            ]);
        }

        $this->success('Approved successfully!', 'Success!', redirectTo: "/submissions/{$this->submissionCode}", position: 'toast-bottom');
        $this->approvalModal = false;
    }

    public function render()
    {
        return view('livewire.components.submission.detail', [
            'submissionItem' => $this->submissionItem
        ]);
    }
}
