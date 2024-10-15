<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    public $table = "cart";

    public $guarded = [];

    public function user(): BelongsTo {
        return $this->belongsTo(Employee::class, 'nip');
    }

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class, 'item_code');
    }
}
