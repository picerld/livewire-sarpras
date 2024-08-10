<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomingItemDetail extends Model
{
    public $table = "incoming_item_detail";

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    public function incomingItem(): BelongsTo {
        return $this->belongsTo(IncomingItem::class, 'incoming_item_code');
    }

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class, 'item_code');
    }
}
