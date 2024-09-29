<?php

namespace App\Livewire\Components\Submission;

use App\Models\Submission;
use App\Models\SubmissionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        dd($this->submissionItem);
    }

    public function save(SubmissionDetail $submissionDetail): void
    {
        $item = $this->submissionItem->item;

        // check if stock is 0 
        // if ($this->submissionItem->item->stock == 0) {
        //     $this->approvalModal = false;
        //     $this->error("Stok untuk $item->name habis!", 'Oops!', position: 'toast-bottom');
        //     return;
        // }

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

        // // update stock and submission detail
        if ($submissionDetail) {
            $submissionDetail->update([
                'qty_accepted' => $this->submissionApproved['qty'],
                'accepted_by' => Auth::user()->id,
            ]);
            // $submissionDetail->item->update([
            //     'stock' => $submissionDetail->item->stock - $submissionDetail->qty_accepted
            // ]);
        }

        // validate if stock < stock min
        // if ($item->stock <= $item->minimum_stock) {
        //     $this->approvalModal = false;
        //     $this->warning("Jumlah stock $item->name, kurang dari stock minimum!", 'Success!', redirectTo: "/submissions/{$this->submissionCode}", position: 'toast-bottom');
        //     return;
        // }

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
