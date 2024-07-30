<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    public $table = "suppliers";

    protected $guarded = ['id'];

    public function incomingItems(): HasMany {
        return $this->hasMany(IncomingItem::class, 'supplier_id');
    }
}
