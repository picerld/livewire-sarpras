<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    public $table = "employees";

<<<<<<< Updated upstream
    protected $guarded = ['nip'];
    
    protected $primaryKey = 'nip';
    protected $keyType = 'string';

    public function getRouteKeyName()
    {
        return 'nip';
    }
=======
    protected $guarded = [];
>>>>>>> Stashed changes

    public function user(): HasOne {
        return $this->hasOne(User::class, 'nip');
    }
}
