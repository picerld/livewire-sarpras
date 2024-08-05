<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncomingItem extends Model
{
    use HasFactory;

    public $table = "incoming_item";
    protected $guarded = ['id'];

    public function users(): BelongsTo {
        return $this->belongsTo(Employee::class, 'user_id');
    }

    public function suppliers(): BelongsTo {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function incomingItemDetail(): HasMany
    {
        return $this->hasMany(IncomingItemDetail::class, 'incoming_item_id');
    }
}
