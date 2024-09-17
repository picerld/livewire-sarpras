<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OutgoingItem extends Model
{
    use HasFactory;

    public $table = "outgoing_items";

    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    public function users(): BelongsTo {
        return $this->belongsTo(Employee::class, 'nip');
    }

    public function outgoingItemDetail(): HasMany {
        return $this->hasMany(OutgoingItemDetail::class, 'outgoing_item_code', 'id');
    }
}
