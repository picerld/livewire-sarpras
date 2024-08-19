<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory;

    public $table = "submission";

    protected $guarded = [];
    public $keyType = 'string';
    public $incrementing = false;

    public function users(): BelongsTo {
        return $this->belongsTo(Employee::class, 'nip');
    }

    public function submissionDetail(): HasMany {
        return $this->hasMany(SubmissionDetail::class, 'submission_code', 'id');
    }
}
