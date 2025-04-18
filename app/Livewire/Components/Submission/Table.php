<?php

namespace App\Livewire\Components\Submission;

use App\Exports\SubmissionExport;
use App\Models\User;
use App\Models\Submission;
use App\Models\SubmissionDetail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'id', 'label' => 'Kode'],
        ['key' => 'users_name', 'label' => 'User'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'total_items', 'label' => 'Total Item'],
        ['key' => 'regarding', 'label' => 'Perihal'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
    ];

    public int $perPage = 5;

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'DESC'];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createSubmission = false;
    public bool $submissionExportPdf = false;

    // filter
    public $selectedUser = null;
    public $selectedStatus = null;
    public $fromDate = null;
    public $toDate = null;

    public function tableDrawer()
    {
        $this->drawerIsOpen = true;
    }

    public function createSubmissionModal()
    {
        $this->createSubmission = true;
    }

    public function submissionPdfModal()
    {
        $this->submissionExportPdf = true;
    }

    public function submissions(): LengthAwarePaginator
    {
        return Submission::query()
            ->withAggregate('users', 'name')
            ->when($this->search, function (Builder $query) {
                $query->whereHas('users', function (Builder $query) {
                    $query->where('name', 'LIKE', "%$this->search%");
                })
                    ->orWhere('id', 'LIKE', "%$this->search%");
            })
            ->when($this->selectedStatus, fn(Builder $q) => $q->where('status', $this->selectedStatus))
            ->when($this->selectedUser, fn(Builder $q) => $q->where('nip', $this->selectedUser))
            ->when($this->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->orderBy('status', 'ASC')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, ['id', 'users_name', 'total_items', 'status', 'regarding']);
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

    public function delete(Submission $submission, SubmissionDetail $submissionDetail): void
    {
        $submission->delete();
        $submissionDetail->delete();
        $this->success("Submission with id #$submission->id successfully deleted!!", 'Good bye!', position: 'toast-bottom');
    }

    public function exportCsv()
    {
        return Excel::download(new SubmissionExport, 'submissions-' . Date::now()->format('dmYHms') . '.xlsx');
    }

    public function render()
    {
        $users = User::withAggregate('employee', 'name')->get();
        // mapping users
        $userMap = $users->map(function (User $user) {
            return [
                'id' => $user->nip,
                'name' => $user->employee->name
            ];
        });

        $userNameExplode = $users->map(function (User $user) {
            return [
                'id' => $user->nip,
                'name' => strtoupper(trim(explode('@', $user->username)[0])),
            ];
        });

        $status = [
            [
                'id' => '1',
                'name' => 'PENDING'
            ],
            [
                'id' => '2',
                'name' => 'ACCEPTED'
            ],
            [
                'id' => '3',
                'name' => 'REJECTED'
            ],
        ];

        return view('livewire.components.submission.table', [
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'users' => $userMap,
            'status' => $status,
            'userNameExplode' => $userNameExplode,
            'submissions' => $this->submissions()
        ]);
    }
}
