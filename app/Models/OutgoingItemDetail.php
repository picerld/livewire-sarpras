<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutgoingItemDetail extends Model
{
    use HasFactory;

    public $table = "outgoing_item_detail";

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    public function outgoingItem(): BelongsTo {
        return $this->belongsTo(outgoingItem::class, 'outgoing_item_code');
    }
    
    public function item(): BelongsTo {
        return $this->belongsTo(Item::class, 'item_code');
    }
}
