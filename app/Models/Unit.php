<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    public $table = "unit";

    protected $guarded = ['id'];

    public function user(): HasMany {
        return $this->hasMany(User::class);
    }
}
