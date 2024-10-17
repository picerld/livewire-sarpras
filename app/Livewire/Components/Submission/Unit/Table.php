<?php

namespace App\Livewire\Components\Submission\Unit;

use App\Models\Submission;
use App\Models\SubmissionDetail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'id', 'label' => 'Kode', 'class' => 'text-base'],
        ['key' => 'status', 'label' => 'Status', 'class' => 'text-base'],
        ['key' => 'total_items', 'label' => 'Total Item', 'class' => 'text-base'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'text-base'],
    ];

    public int $perPage = 5;

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    public $item;
    public $detailSubmission = false;

    public $selectedStatus = null;
    public $fromDate = null;
    public $toDate = null;

    public function detailSubmissionModal($submissionCode)
    {
        $this->detailSubmission = true;
        $this->item = SubmissionDetail::where('submission_code', $submissionCode)->get();
    }

    public function submissions(): LengthAwarePaginator
    {
        return Submission::query()
            ->where('nip', Auth::user()->nip)
            ->withAggregate('users', 'name')
            ->when($this->search, function (Builder $query) {
                $query->whereHas('users', function (Builder $query) {
                    $query->where('name', 'LIKE', "%$this->search%");
                })
                    ->orWhere('id', 'LIKE', "%$this->search%")
                    ->orWhere('status', 'LIKE', "%$this->search%")
                    ->orWhere('total_items', 'LIKE', "%$this->search%")
                    ->orWhere('created_at', 'LIKE', "%$this->search%");
            })
            ->when($this->selectedStatus, fn(Builder $q) => $q->where('status', $this->selectedStatus))
            ->when($this->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->orderBy('status', 'ASC')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['id', 'total_items', 'status']);
    }

    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function clear(): void
    {
        $this->reset();
        $this->resetPage();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    public function render()
    {
        $status = [
            [
                'id' => '1',
                'name' => 'Pending'
            ],
            [
                'id' => '2',
                'name' => 'Accepted'
            ],
            [
                'id' => '3',
                'name' => 'Rejected'
            ],
        ];

        return view('livewire.components.submission.unit.table', [
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'status' => $status,
            'submissions' => $this->submissions()
        ]);
    }
}
