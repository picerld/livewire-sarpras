<?php

namespace App\Livewire\Components\Submission;

use App\Helpers\GenerateCodeHelper;
use App\Models\Submission;
use App\Models\SubmissionDetail;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Table extends Component
{
    use WithPagination, Toast;

    public $headers = [
        ['key' => 'id', 'label' => 'Kode', 'class' => 'dark:text-slate-300'],
        ['key' => 'users_name', 'label' => 'User', 'class' => 'dark:text-slate-300'],
        ['key' => 'status', 'label' => 'Status', 'class' => 'dark:text-slate-300'],
        ['key' => 'total_items', 'label' => 'Total Item', 'class' => 'dark:text-slate-300'],
        ['key' => 'regarding', 'label' => 'Perihal', 'class' => 'dark:text-slate-300'],
        ['key' => 'created_at', 'label' => 'Tanggal', 'class' => 'dark:text-slate-300'],
    ];

    public $search = "";
    public $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    // drawer
    public bool $drawerIsOpen = false;
    // modal
    public bool $createSubmission = false;

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
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5, ['id', 'users_name', 'total_items', 'status']);
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
        $this->success("Submission with code " . $submission->id . " successfully deleted!!", 'Good bye!', position: 'toast-bottom');
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

        return view('livewire.components.submission.table', [
            'headers' => $this->headers,
            'sortBy' => $this->sortBy,
            'users' => $userMap,
            'status' => $status,
            'submissions' => $this->submissions()
        ]);
    }
}
