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

    protected $guarded = [];

    protected $primaryKey = 'code';
    protected $keyType = 'string';

    public function getRouteKeyName()
    {
        return 'code';
    }
    public function getKeyName()
    {
        return 'code';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function incomingItemsDetail(): HasMany
    {
        return $this->hasMany(IncomingItemDetail::class, 'item_code');
    }
}
