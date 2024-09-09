<?php

namespace App\Livewire\Components\Submission;

use App\Models\Submission;
use Livewire\Component;
use Mary\Traits\Toast;

class FormAcceptance extends Component
{
    use Toast;

    public $submissionCode;
    public Submission $submission;

    public function mount($submissionCode): void
    {
        $this->submissionCode = $submissionCode;
        $this->submission = Submission::where('id', $this->submissionCode)->first();
    }

    public function updateStatus(string $status): void
    {
        $this->submission->update(['status' => $status]);
    
        $message = $status === 'accepted' ? 'Approved successfully!' : 'Rejected successfully!';
        $this->success($message, 'Success!', redirectTo: "/submissions/" . $this->submission->id, position: 'toast-bottom');
    }    

    public function render()
    {
        return view('livewire.components.submission.form-acceptance');
    }
}
