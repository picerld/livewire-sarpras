<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    public $table = "suppliers";

    protected $guarded = [];

    protected $primaryKey = ['code'];
    protected $keyType = "string";

    public function incomingItems(): HasMany {
        return $this->hasMany(IncomingItem::class, 'supplier_id');
    }
}
