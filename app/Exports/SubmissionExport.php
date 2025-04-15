<?php

namespace App\Exports;

use App\Models\Submission;
use App\Models\SubmissionDetail;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubmissionExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $submissions = SubmissionDetail::join('submission', 'submission.id', '=', 'submission_detail.submission_code')
            ->join('items', 'items.id', '=', 'submission_detail.item_code')
            ->join('users', 'users.nip', '=', 'submission.nip')
            ->select('users.username as unit', 'submission.status', 'items.name', 'submission_detail.qty', 'submission_detail.qty_accepted', 'submission.created_at')
            ->get();

        return view('exports.csv.submissions', [
            'submissions' => $submissions
        ]);
    }
}
