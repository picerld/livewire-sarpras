<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestDetail extends Model
{
    use HasFactory;

    public $table = "request_detail";

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    public function request(): BelongsTo {
        return $this->belongsTo(Request::class, 'request_code');
    }
    
    public function item(): BelongsTo {
        return $this->belongsTo(Item::class, 'item_code');
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'nip');
    }
}
