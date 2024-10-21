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

    protected $guarded = ['created_at', 'updated_at'];
    protected $keyType = 'string';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function incomingItemsDetail(): HasMany
    {
        return $this->hasMany(IncomingItemDetail::class, 'id');
    }

    public function submissionDetail(): HasMany
    {
        return $this->hasMany(SubmissionDetail::class, 'id');
    }

    public function outgoingItem(): HasMany
    {
        return $this->hasMany(OutgoingItem::class, 'id');
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class, 'id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(RequestDetail::class, 'id');
    }
}
