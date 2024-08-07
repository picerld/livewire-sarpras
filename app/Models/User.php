<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $table = "users";

<<<<<<< HEAD
<<<<<<< Updated upstream
    protected $guarded = ['id'];
=======
    protected $guarded = ['nip'];

=======
    protected $guarded = ['nip'];
>>>>>>> faa95b83bec67b4ce7b381a422654c3e64f2496c
    protected $primaryKey = 'nip';
    protected $keyType = 'string';

    public function getRouteKeyName()
    {
        return 'nip';
    }
<<<<<<< HEAD
>>>>>>> Stashed changes
=======
>>>>>>> faa95b83bec67b4ce7b381a422654c3e64f2496c

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'nip');
    }

    public function incomingItems(): HasMany {
        return $this->hasMany(IncomingItem::class, 'nip');
    }
}
