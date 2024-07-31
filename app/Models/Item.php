<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    public $table = "items";

    protected $guarded = ['id'];

    protected $casts = [
        'images' => 'array'
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function incomingItemsDetail(): HasMany {
        return $this->hasMany(IncomingItemDetail::class, 'item_id');
    }
}
