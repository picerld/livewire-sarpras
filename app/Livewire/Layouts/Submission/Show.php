<?php

namespace App\Livewire\Layouts\Submission;

use App\Models\SubmissionDetail;
use Livewire\Component;

class Show extends Component
{
    public $submissions;
    public $submissionCode;

    public function mount($submissionCode)
    {
        $this->submissionCode = $submissionCode;
        $this->submissions = SubmissionDetail::where('submission_code', $this->submissionCode)->get();
    }

    public function render()
    {
        return view('livewire.layouts.submission.show');
    }
}
