<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncomingItem extends Model
{
    use HasFactory;

    public $table = "incoming_items";
    protected $guarded = ['id'];

    public function users(): BelongsTo {
        return $this->belongsTo(Employee::class, 'nip');
    }

    public function suppliers(): BelongsTo {
        return $this->belongsTo(Supplier::class, 'supplier_code');
    }

    public function incomingItemDetail(): HasMany
    {
        return $this->hasMany(IncomingItemDetail::class, 'incoming_item_code');
    }
}
