<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncomingItem extends Model
{
<<<<<<< Updated upstream
    use HasFactory;

    public $table = "incoming_items";
    protected $guarded = ['id'];
=======
    public $table = "incoming_items";

    protected $guarded = [];

    protected $primaryKey = 'code';
    protected $keyType = 'string';
>>>>>>> Stashed changes

    public function users(): BelongsTo {
        return $this->belongsTo(Employee::class, 'user_id');
    }

    public function suppliers(): BelongsTo {
<<<<<<< Updated upstream
        return $this->belongsTo(Supplier::class, 'supplier_id');
=======
        return $this->belongsTo(Supplier::class, 'id');
>>>>>>> Stashed changes
    }

    public function incomingItemDetail(): HasMany
    {
<<<<<<< Updated upstream
        return $this->hasMany(IncomingItemDetail::class, 'incoming_item_id');
=======
        return $this->hasMany(IncomingItemDetail::class, 'id');
>>>>>>> Stashed changes
    }
}
