<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomingItemDetail extends Model
{
    use HasFactory;

    public $table = "incoming_item_detail";
    protected $guarded = ['id'];

    public function incomingItem(): BelongsTo {
        return $this->belongsTo(IncomingItem::class, 'incoming_item_id');
    }

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
