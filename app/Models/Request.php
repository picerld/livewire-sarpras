<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    use HasFactory;

    public $table = "request";

    protected $guarded = [];
    public $keyType = 'string';
    public $incrementing = false;

    public function users(): BelongsTo {
        return $this->belongsTo(Employee::class, 'nip');
    }

    public function requestDetail(): HasMany {
        return $this->hasMany(RequestDetail::class, 'request_code', 'id');
    }

    public function outgoingItem(): HasMany {
        return $this->hasMany(OutgoingItem::class, 'id');
    }
}
