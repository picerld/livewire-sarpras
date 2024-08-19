<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionDetail extends Model
{
    public $table = "submission_detail";

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    public function submission(): BelongsTo {
        return $this->belongsTo(Submission::class, 'submission_code');
    }
    
    public function item(): BelongsTo {
        return $this->belongsTo(Item::class, 'item_code');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'nip');
    }

}
