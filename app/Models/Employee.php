<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;
    
    public $table = "employees";

<<<<<<< Updated upstream
    protected $guarded = ['id'];

    public function user(): HasMany {
        return $this->hasMany(User::class);
=======
    protected $guarded = ['nip'];
    
    protected $primaryKey = 'nip';
    protected $keyType = 'integer';

    public function getRouteKeyName()
    {
        return 'nip';
    }

    public function getKeyName()
    {
        return 'nip';
    }

    public function user(): HasOne {
        return $this->hasOne(User::class, 'nip');
>>>>>>> Stashed changes
    }
}
