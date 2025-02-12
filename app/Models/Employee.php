<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;
    
    public $table = "employees";
  
    protected $guarded = [];

    public function user(): HasOne {
        return $this->hasOne(User::class);
    }

    public function submission(): HasMany {
        return $this->hasMany(Submission::class);
    }

    public function requestDetail(): HasMany {
        return $this->hasMany(RequestDetail::class);
    }
}
