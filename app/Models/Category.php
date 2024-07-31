<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public $table = "category";

    protected $guarded = ['id'];

    public function item(): Hasmany {
        return $this->hasMany(Category::class);
    }
}
